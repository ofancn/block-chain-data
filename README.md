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

cf306668448c89fac6492293c50bbd9bea29ca119d658037ebbe6207382317e2
int(10)
bool(true)
Array
(
    [0] => Array
        (
            [id] => 1
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559583436
            [prevhash] => 0000000000000000000000000000000000000000000000000000000000000000
            [blockhash] => 59011e78236a8446db225a7512584b612224e4fa48b6669d959efcb3b46ff807
            [datalen] => 16
            [data] => test0
        )

)
Array
(
    [0] => Array
        (
            [id] => 0
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559583436
            [prevhash] => 0000000000000000000000000000000000000000000000000000000000000000
            [blockhash] => 59011e78236a8446db225a7512584b612224e4fa48b6669d959efcb3b46ff807
            [datalen] => 16
            [data] => test0
        )

    [1] => Array
        (
            [id] => 0
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559583436
            [prevhash] => 59011e78236a8446db225a7512584b612224e4fa48b6669d959efcb3b46ff807
            [blockhash] => 5cf6e72b4a7debc047d81a41f8b7ad295bf6e7d9144f6718ebfa5c6ff5fd1ee2
            [datalen] => 16
            [data] => test1
        )

    [2] => Array
        (
            [id] => 0
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559583436
            [prevhash] => 5cf6e72b4a7debc047d81a41f8b7ad295bf6e7d9144f6718ebfa5c6ff5fd1ee2
            [blockhash] => 964ef1e93733cea514e2aa1fa3ad50d75195b14be2a2012464ed699541fea154
            [datalen] => 16
            [data] => test2
        )

    [3] => Array
        (
            [id] => 0
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559583436
            [prevhash] => 964ef1e93733cea514e2aa1fa3ad50d75195b14be2a2012464ed699541fea154
            [blockhash] => 6516d2bdcd13353b778f68b8533572a38e7a54c22204306f4262cfde6fe840c7
            [datalen] => 16
            [data] => test3
        )

    [4] => Array
        (
            [id] => 0
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559583436
            [prevhash] => 6516d2bdcd13353b778f68b8533572a38e7a54c22204306f4262cfde6fe840c7
            [blockhash] => 9d07d85bcdeb3443661c7c72403396b8ee49e98b3f9e1f015e5e425a2d5d2814
            [datalen] => 16
            [data] => test4
        )

    [5] => Array
        (
            [id] => 0
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559583436
            [prevhash] => 9d07d85bcdeb3443661c7c72403396b8ee49e98b3f9e1f015e5e425a2d5d2814
            [blockhash] => 249f2119070fb533fa37151db0df6a8bc7a8c53eca07eb14a204d6d85baff94a
            [datalen] => 16
            [data] => test5
        )

    [6] => Array
        (
            [id] => 0
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559583436
            [prevhash] => 249f2119070fb533fa37151db0df6a8bc7a8c53eca07eb14a204d6d85baff94a
            [blockhash] => 86f932ace79d51bca7e9052b23f76b27c4aef26825e892e18eb8d8c28951a5e5
            [datalen] => 16
            [data] => test6
        )

    [7] => Array
        (
            [id] => 0
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559583436
            [prevhash] => 86f932ace79d51bca7e9052b23f76b27c4aef26825e892e18eb8d8c28951a5e5
            [blockhash] => 13743c728e6403586e4aa71445870d128c1d9d1aa89cab4c716876aeb4fc3377
            [datalen] => 16
            [data] => test7
        )

    [8] => Array
        (
            [id] => 0
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559583436
            [prevhash] => 13743c728e6403586e4aa71445870d128c1d9d1aa89cab4c716876aeb4fc3377
            [blockhash] => 8a06b67f38c785340826ddfbf5bc5ed479a0edda70005d8e4b59e2e51f944aad
            [datalen] => 16
            [data] => test8
        )

    [9] => Array
        (
            [id] => 0
            [magic] => d5e8a97f
            [version] => 1
            [timestamp] => 1559583436
            [prevhash] => 8a06b67f38c785340826ddfbf5bc5ed479a0edda70005d8e4b59e2e51f944aad
            [blockhash] => 0e3922eed9b5f5f846285ed4b238ca6ef319106eae55671b18bbead765d6bbd3
            [datalen] => 16
            [data] => test9
        )

)

~~~
