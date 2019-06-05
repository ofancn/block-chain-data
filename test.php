<?php
require './vendor/autoload.php';
use Invoice\BlockChainData;

//创建账本
$BlockChain = new BlockChainData('BlockChain.dat');

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