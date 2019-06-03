<?php
namespace Invoice;

use PhpAes\Aes;
use Throwable;
use Exception;

/**
 * 区块链记账本
 */
class BlockChainData
{

    protected $fn;

    protected $_magic;

    protected $_hashalg;

    protected $_hashlen;

    protected $_blksize;

    protected $_aes;

    /**
     * 账本文件路径
     *
     * @param string $fn
     */
    public function __construct(string $fn, $z, $mode = 'ECB', $iv = null, $magic = 0xD5E8A97F, string $hashalg = 'sha256', int $hashlen = 32)
    {
        $this->_aes = new Aes($z, $mode, $iv);
        $this->fn = $fn;
        $this->_magic = $magic;
        $this->_hashalg = $hashalg;
        $this->_hashlen = intval($hashlen);
        $this->_blksize = 13 + $this->_hashlen;
    }

    /**
     * 返回区块数量
     *
     * @return number
     */
    public function count()
    {
        if (!file_exists($this->fn . '.idx'))
            return 0;
        return (filesize($this->fn . '.idx') - 4) / 8;
    }

    /**
     * 返回账本Hash
     *
     * @return NULL|string
     */
    public function getHash()
    {
        if (!file_exists($this->fn))
            return null;
        return hash_file($this->_hashalg, $this->fn);
    }

    /**
     * 校对账本hash
     *
     * @param string $hash
     * @return NULL|boolean
     */
    public function verifyHash($hash)
    {
        if (!file_exists($this->fn))
            return null;
        return hash_file($this->_hashalg, $this->fn) === $hash;
    }

    /**
     * 分页查询账本
     *
     * @param int $limit
     *            条数
     * @param int $offset
     *            偏移
     * @param boolean $verify
     *            校对数据
     * @throws Throwable 区块链被破坏
     * @return null|array
     */
    public function find($limit = 1, $offset = 0, $verify = true)
    {
        $fn = $this->fn . '.idx';
        if (!file_exists($fn))
            return null;
        $fp = fopen($fn, 'rb');
        fseek($fp, 4 + ($offset * 8));
        $indexs = [];
        $id = $offset;
        for ($i = 0; $i < $limit; $i++) {
            $ofs = unpack('V', fread($fp, 4))[1];
            $len = unpack('V', fread($fp, 4))[1] - $this->_blksize;
            $indexs[$ofs] = [
                ++$id,
                $len
            ];
        }
        fclose($fp);
        return $this->walkChain($indexs, $verify);
    }

    /**
     * 返回所有账本数据
     *
     * @param boolean $verify
     *            校对数据
     * @throws Throwable 区块链被破坏
     * @return boolean|null
     */
    public function findAll($verify = true)
    {
        return $this->find($this->count(), 0, $verify);
    }

    /**
     * 创建块
     *
     * @param string $data
     * @throws Throwable
     * @return boolean
     */
    public function addBlock(string $data)
    {
        $data = $this->encrypt($data);
        $indexfn = $this->fn . '.idx';
        if (file_exists($this->fn)) {
            if (!$ix = fopen($indexfn, 'r+b'))
                throw new Exception("Can't open " . $indexfn);
            $maxblock = unpack('V', fread($ix, 4))[1];
            $zpos = (($maxblock * 8) - 4);
            fseek($ix, $zpos, SEEK_SET);
            $ofs = unpack('V', fread($ix, 4))[1];
            $len = unpack('V', fread($ix, 4))[1];
            if (!$bc = fopen($this->fn, 'r+b'))
                throw new Exception("Can't open " . $this->fn);
            fseek($bc, $ofs, SEEK_SET);
            $block = fread($bc, $len);
            $hash = hash($this->_hashalg, $block);
            fseek($bc, 0, SEEK_END);
            $pos = ftell($bc);
            $this->write_block($bc, $data, $hash);
            fclose($bc);
            $this->update_index($ix, $pos, strlen($data), ($maxblock + 1));
            fclose($ix);
            return true;
        } else {
            if (file_exists($this->fn))
                throw new Exception('Blockchain data file already exists!');
            if (file_exists($indexfn))
                throw new Exception('Blockchain index file already exists!');
            $bc = fopen($this->fn, 'wb');
            $ix = fopen($indexfn, 'wb');
            $this->write_block($bc, $data, str_repeat('00', $this->_hashlen));
            $this->update_index($ix, 0, strlen($data), 1);
            fclose($bc);
            fclose($ix);
            return true;
        }
    }

    protected function walkChain(array $indexs, $verify = true)
    {
        $block = [];
        $fp = fopen($this->fn, 'rb');
        $i = 0;
        try {
            foreach ($indexs as $ofs => $val) {
                fseek($fp, $ofs);
                $header = fread($fp, $this->_blksize);
                $magic = $this->unpack32($header, 0);
                $version = ord($header[4]);
                $timestamp = $this->unpack32($header, 5);
                $prevhash = bin2hex(substr($header, 9, $this->_hashlen));
                $datalen = $this->unpack32($header, -4);
                $data = fread($fp, $datalen);
                $hash = hash($this->_hashalg, $header . $data);

                if ($datalen !== $val[1] || strlen($data) !== $datalen) {
                    // 区块链被破坏
                    throw new Exception('Blockchain is destroyed');
                }

                $block[$i] = [
                    'id' => $val[0],
                    'magic' => dechex($magic),
                    'version' => $version,
                    'timestamp' => $timestamp,
                    'prevhash' => $prevhash,
                    'blockhash' => $hash,
                    'datalen' => $datalen,
                    'data' => $this->decrypt($data)
                ];
                if ($verify && isset($block[$i - 1])) {
                    if ($block[$i]['prevhash'] !== $block[$i - 1]['blockhash']) {
                        // 区块链被破坏
                        throw new Exception('Blockchain is destroyed');
                    }
                }
                $i++;
            }
        } catch (Throwable $e) {
            fclose($fp);
            // 区块链被破坏
            throw new Exception('Blockchain is destroyed');
        }
        fclose($fp);
        return $block;
    }

    protected function write_block(&$fp, $data, $prevhash)
    {
        fwrite($fp, pack('V', $this->_magic), 4); // Magic
        fwrite($fp, chr(1), 1); // Version
        fwrite($fp, pack('V', time()), 4); // Timestamp
        fwrite($fp, hex2bin($prevhash), $this->_hashlen); // Previous Hash
        fwrite($fp, pack('V', strlen($data)), 4); // Data Length
        fwrite($fp, $data, strlen($data)); // Data
    }

    protected function update_index(&$fp, $pos, $datalen, $count)
    {
        fseek($fp, 0, SEEK_SET);
        fwrite($fp, pack('V', $count), 4); // Record count
        fseek($fp, 0, SEEK_END);
        fwrite($fp, pack('V', $pos), 4); // Offset
        fwrite($fp, pack('V', ($datalen + $this->_blksize)), 4); // Length
    }

    protected function unpack32($data, $ofs)
    {
        return unpack('V', substr($data, $ofs, 4))[1];
    }

    protected function decrypt($str)
    {
        return $this->_aes->decrypt($str);
    }

    protected function encrypt($str)
    {
        return $this->_aes->encrypt($str);
    }
}
