#!/usr/bin/env python
import pika

connection = pika.BlockingConnection(pika.ConnectionParameters(
               'localhost'))
channel = connection.channel()

#channel.queue_declare(queue='mensajes')

channel.basic_publish(exchange='exchangename',
                      routing_key='',
                      body='Meow')
print " [x] Sent 'Meow!'"

connection.close()
