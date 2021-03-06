<?php
namespace app\controllers;
use app\models\Users;
use app\models\Details;
use app\models\Settelments;
use app\models\Transactions;
use app\extensions\action\Functions;
use app\extensions\action\Bitcoin;
use \lithium\template\View;
use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;


class ClosureController extends \lithium\action\Controller {
	public function email($username=null){
		if($username==""){
			$data = Settelments::find("all",array(
				'conditions' => array('sendemail'=>"No"),
				'limit' => 10
			));
			foreach($data as $user){
				$this->SendEmail($user['email'],$user['name'],$user['address'],$user['username']);
				$update = array(
					'sendemail' => 'Yes'
				);
				Settelments::find("all",array(
					'conditions'=>array(
						'username'=>$user['username'],					
					)
				))->save($update);
			}
		}else{
			$data = Settelments::find("first",array(
				'conditions'=>array(
					'username'=>$username,					
				)
			));
				$this->SendEmail($data['email'],$data['name'],$data['address'],$data['username']);			
				$update = array(
					'sendemail' => 'Yes'
				);
				Settelments::find("all",array(
					'conditions'=>array(
						'username'=>$data['username'],					
					)
				))->save($update);
				
		}
		
		$count = Settelments::count(array('sendemail'=>'Yes'));
		return compact('count');
		
	}

	public function SendEmail($email, $name, $address, $username){
			$view  = new View(array(
				'loader' => 'File',
				'renderer' => 'File',
				'paths' => array(
					'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
				)
			));
			$data = array(
				'email' => $email,
				'name' => $name,
				'address' => $address,
				'username' => $username
			);
			$body = $view->render(
				'template',
				compact('data'),
				array(
					'controller' => 'closure',
					'template'=>'settle',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
	
			$message = Swift_Message::newInstance();
			$message->setSubject("rbitco.in Closure! Restore your bitcoins");
			$message->setFrom(array('no-reply@rbitco.in' => 'rbitco.in No Reply'));
			$message->setTo($email);
			$message->addBcc("nilamdoc@gmail.com");

			$message->setBody($body,'text/html');
			$mailer->send($message);
	
	}

	public function index($id=null){
	
	$data = Settelments::find("first",array(
		'conditions'=>array('address'=>$id)
	));
	if(count($data)==0)	{$msg = "Incorrect URL entered!";}
	return compact('data','msg');
	}

	public function pkey($username, $email, $address){
			$data = Settelments::find("first",array(
				'conditions'=>array(
					'address'=>$address,
					'username'=>$username,					
					'email'=>$email,					
				)
			));
			if(count($data)==0){
				$key = "Not Authorised";
				$return = "No";
			}else{
			$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
				$key = $bitcoin->dumpprivkey($address);
				$return = "Yes";
				$update = array(
					'updated' => 'Yes',
					'updatedDate' => new \MongoDate(),	
					'updatedIP' => $_SERVER['REMOTE_ADDR'],
				);
				Settelments::find("all",array(
					'conditions'=>array(
						'address'=>$address,
						'username'=>$username,					
						'email'=>$email,					
					)
				))->save($update);
				
				
			}
			
		$data = array(
			'key' => $key,
			'return' => $return
		);
		return $this->render(array('json' => $data, 'status'=> 200));
	}

}
?>