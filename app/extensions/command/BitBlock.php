<?php
namespace app\extensions\command;
use app\models\Blocks;
use app\extensions\action\Bitcoin;

//every 2 seconds cron job for adding transactions....
ini_set('memory_limit', '-1');

class BitBlock extends \lithium\console\Command {

    public function run() {
	$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
	$getblockcount = $bitcoin->getblockcount();
	
	$height = Blocks::find('first',array(
		'order' => array('height'=>'DESC')
	));
	
	$h = (int)$height['height'] + 1;
		for($i = $h;$i<=$h+250;$i++)	{
			$data = array();
			if($i <= $getblockcount){
				$getblockhash = $bitcoin->getblockhash($i);
				$getblock = $bitcoin->getblock($getblockhash);

				$data = array(
					'confirmations' => $getblock['confirmations'],
					'height' => $getblock['height'],
					'version' => $getblock['version'],
					'time' => new \MongoDate ($getblock['time']),
					'difficulty' => $getblock['difficulty'],
				);


				$txid = 0;
				foreach($getblock['tx'] as $txx){
					$getrawtransaction = $bitcoin->getrawtransaction((string)$txx);
			//	print_r($getrawtransaction);
					$decoderawtransaction = $bitcoin->decoderawtransaction($getrawtransaction);
			//		print_r($decoderawtransaction);
					
					$data['txid'][$txid]['version'] = $decoderawtransaction['version'];
					foreach($decoderawtransaction['vin'] as $vin){
						$data['txid'][$txid]['vin']['coinbase'] = $vin['coinbase'];
						$data['txid'][$txid]['vin']['sequence'] = $vin['sequence'];						
					}	
					foreach($decoderawtransaction['vout'] as $vout){
						$data['txid'][$txid]['vout']['value'] = $vout['value'];
						$data['txid'][$txid]['vout']['n'] = $vout['n'];
						$data['txid'][$txid]['vout']['scriptPubKey']['addresses'] = $vout['scriptPubKey']['addresses'];						
					}
					$txid ++;
				}
			
				Blocks::create()->save($data);
			//	print_r($getblock);
			}
		}
	}
}
?>