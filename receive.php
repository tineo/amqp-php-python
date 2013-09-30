<?php

    $amqpConnection = new AMQPConnection();
    $amqpConnection->setLogin("guest");
    $amqpConnection->setPassword("guest");
    /*$amqpConnection->setVhost("/");
    */
    $amqpConnection->setHost("localhost");
    $amqpConnection->connect();

    if(!$amqpConnection->isConnected()) {
        die("Cannot connect to the broker, exiting !\n");
    }


// Open channel
$channel = new AMQPChannel($amqpConnection);

// Open Queue and bind to exchange
$queue = new AMQPQueue($channel);
$queue->setName('mensajes');
//$queue->declareQueue();


$queue->bind('exchangename');


    
function processMessage($envelope, $queue) {
        
    echo "Message " . $envelope->getBody() . "\n";

}


$queue->consume("processMessage");



/*
// Prevent message redelivery with AMQP_AUTOACK param
while ($envelope = $queue->get(AMQP_AUTOACK)) {
    echo ($envelope->isRedelivery()) ? 'Redelivery' : 'New Message';
    
    $json =  $envelope->getBody();
    $msg = json_decode($json,true);

    var_dump($msg);
}
*/
