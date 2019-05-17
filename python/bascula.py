#!/usr/bin/python
import serial
import time
import mysql.connector
	
conn = mysql.connector.connect(
         user='techno',
         password='techno',
         host='192.168.0.150',
         database='ts5_sas')

cur = conn.cursor()
arduino=serial.Serial('/dev/ttyUSB0',baudrate=9600, timeout = 0.5)
cadena=''
idBascula=2

while True:
      
      while arduino.inWaiting() > 0:
				cadena += arduino.readline()
				
				valor=cadena[7:9]
				
				if valor == "Wt":
						peso=cadena[12:18]
	
						
						if peso > 0:
							try:
								cur.execute("REPLACE INTO registro_basculas (Gramos,idBascula) VALUES (%s,%s);",(peso,idBascula))							
								conn.commit()
								print cadena[12:18]
								cadena=''
							except:
  								print("Something else went wrong")
							
						else:
							peso=0
				else:
					cadena=''
								
	    
arduino.close()
cur.close()
conn.close()
