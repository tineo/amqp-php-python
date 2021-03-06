#!/usr/bin/python
import pika
import smtplib
import string

def send_mail_neko(text):
	server = smtplib.SMTP('smtp.gmail.com:587')
	server.starttls()
	server.login("one@gmail.com", "somepass")


	SUBJECT = "Test email from Python"
	TO = "your@mail.com"
	FROM = "you@anothermail.com"
	#text = "blah blah blah"
	BODY = string.join((
        "From: %s" % FROM,
        "To: %s" % TO,
        "Subject: %s" % SUBJECT ,
        "",
        text
        ), "\r\n")
	server.sendmail(FROM, [TO], BODY)


#server.quit()



connection = pika.BlockingConnection(pika.ConnectionParameters(
        host='localhost'))
channel = connection.channel()

channel.queue_declare(queue='mensajes')

print ' [*] Waiting for messages. To exit press CTRL+C'

def callback(ch, method, properties, body):
	print " [-] Sending mail"
	send_mail_neko(body)
	print " [x] Received %r" % (body,)
   
    

channel.basic_consume(callback,
                      queue='mensajes',
                      no_ack=True)

channel.start_consuming()
