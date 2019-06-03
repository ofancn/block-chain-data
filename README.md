# BlockChainData
区块链账本

## 安装
~~~php
composer require invoice/block-chain-data
~~~

## 加密技术

http://www.phpaes.com/

## 用法
~~~php
use Invoice\BlockChainData;

//创建账本
$BlockChain = new BlockChainData('BlockChain.dat','KZanthicAtlxIMtgLdTWC07d02Nh3anK');

//新增块
for ($i = 0; $i < 10; $i++) {
    $BlockChain->addBlock('test'.$i);
}

//返回账本Hash
print_r($hash=$BlockChain->getHash());


//返回块数量
var_dump($BlockChain->count());

//校对账本是否被修改
var_dump($BlockChain->verifyHash($hash));

/**
* 分页查询账本
* @param int $limit 条数
* @param int $offset 偏移
* @throws Exception 区块链被破坏
* @return null|array
*/
print_r($BlockChain->find($limit = 1, $offset = 0));

/**
* 返回所有账本数据
* @throws Exception 区块链被破坏
* @return null|array
*/
print_r($BlockChain->findAll());


~~~



~~~php


4fb256bd81c51b0d688137b0c90b29b83178a74bdd34542d6e900e0c5c2ea2ca
int(10)
bool(true)
Array
(
    [0] => Array
        (
            [id] => 1
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559589121
            [prevhash] => 0000000000000000000000000000000000000000000000000000000000000000
            [blockhash] => 25688139628bbc71b30b004b862eda6466ed3fba213871f81d2feef0e274f84d
            [datalen] => 16
            [data] => test0
        )

    [1] => Array
        (
            [id] => 2
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559589121
            [prevhash] => 25688139628bbc71b30b004b862eda6466ed3fba213871f81d2feef0e274f84d
            [blockhash] => fb9e1ca2b949baf33418ccf7435143976f348b55e9f78e94d928fbaa50122710
            [datalen] => 16
            [data] => test1
        )

    [2] => Array
        (
            [id] => 3
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559589121
            [prevhash] => fb9e1ca2b949baf33418ccf7435143976f348b55e9f78e94d928fbaa50122710
            [blockhash] => 1ef8b88d32d3f12299e7ad1b887bd2824cea37f2cec91a3ae2c018b4d6667aa3
            [datalen] => 16
            [data] => test2
        )

    [3] => Array
        (
            [id] => 4
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559589121
            [prevhash] => 1ef8b88d32d3f12299e7ad1b887bd2824cea37f2cec91a3ae2c018b4d6667aa3
            [blockhash] => 61a876e10e5d32c1637c827757a5cb9d4c839968c1d4f045d8029785b43ae2d0
            [datalen] => 16
            [data] => test3
        )

    [4] => Array
        (
            [id] => 5
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559589121
            [prevhash] => 61a876e10e5d32c1637c827757a5cb9d4c839968c1d4f045d8029785b43ae2d0
            [blockhash] => 9ef33914eb147c34c2d6480f3f04ed52e3ae545514238d42f9d686d197436682
            [datalen] => 16
            [data] => test4
        )

    [5] => Array
        (
            [id] => 6
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559589121
            [prevhash] => 9ef33914eb147c34c2d6480f3f04ed52e3ae545514238d42f9d686d197436682
            [blockhash] => afe8f07a2dea70092e0cc0fe0939bffffafe07c9029ee96a51023781df4e50e0
            [datalen] => 16
            [data] => test5
        )

    [6] => Array
        (
            [id] => 7
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559589121
            [prevhash] => afe8f07a2dea70092e0cc0fe0939bffffafe07c9029ee96a51023781df4e50e0
            [blockhash] => f8dfec7219622a78dc286ff8a49c20f3c0718d9e1d8c0c84f4d2f0219cd295ef
            [datalen] => 16
            [data] => test6
        )

    [7] => Array
        (
            [id] => 8
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559589121
            [prevhash] => f8dfec7219622a78dc286ff8a49c20f3c0718d9e1d8c0c84f4d2f0219cd295ef
            [blockhash] => d335ff0adc03a250ab987f0413c832d90f524b5a0218432b3d6be1b7fb9f650c
            [datalen] => 16
            [data] => test7
        )

    [8] => Array
        (
            [id] => 9
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559589121
            [prevhash] => d335ff0adc03a250ab987f0413c832d90f524b5a0218432b3d6be1b7fb9f650c
            [blockhash] => 5ad0c33568b9b370be8222e807c69aaf44a290826dc873c642fad860776becda
            [datalen] => 16
            [data] => test8
        )

    [9] => Array
        (
            [id] => 10
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559589121
            [prevhash] => 5ad0c33568b9b370be8222e807c69aaf44a290826dc873c642fad860776becda
            [blockhash] => ad4fb9c3a2ea7a3d0644c4528635cad914c1a54c29660e607858e8ea495443e4
            [datalen] => 16
            [data] => test9
        )

)

~~~
