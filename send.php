<?php

    $amqpConnection = new AMQPConnection();
    /*$amqpConnection->setLogin("guest");
    $amqpConnection->setPassword("guest");
    $amqpConnection->setVhost("/");
    */
    $amqpConnection->setHost("localhost");
    $amqpConnection->connect();

    if(!$amqpConnection->isConnected()) {
        die("Cannot connect to the broker, exiting !\n");
    }

    $channel = new AMQPChannel($amqpConnection);

    $exchange = new AMQPExchange($channel);
    $exchange->setName("exchangename");
    $exchange->setType(AMQP_EX_TYPE_DIRECT);
    //$exchange->setFlags(AMQP_DURABLE);  
    if($exchange->declareExchange()){

    } 

    $q = new AMQPQueue($channel);
    $q->setName("mensajes");
    //$q->setFlags(AMQP_DURABLE);
    /*if($q->declareQueue()){

    }*/

    //$q->bind(null, "hello");

    $mensaje = json_encode(
                array("mails" => 
                    array(
                        array("to" => "itsudatte01@gmail.com", "body" => "hola Tineo"),
                        array("to" => "itsudatte01@gmail.com", "body" => "hola Tineo"),
                        array("to" => "itsudatte01@gmail.com", "body" => "hola Tineo"),
                    )
                ) 
               );

    
    $message = $exchange->publish($mensaje,
                                    null,
                                    AMQP_NOPARAM,
                                    array("content_type" => "application/json"));
    
    if(!$message) {
        echo "Error: Message '".$message."' was not sent.\n";
    } else {
        echo "Message '".$message."' sent.\n";
    }

    if (!$amqpConnection->disconnect()) {
        throw new Exception("Could not disconnect !");
    }

?>