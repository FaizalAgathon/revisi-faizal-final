import pywhatkit as pwk
import time
import datetime
import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="perpus_padudung"
)
cursor = mydb.cursor()

kontak = '+6281914523696'

# sql = "SELECT * FROM pengembalian WHERE kontak_pengembali like " + kontak
# # print (sql)
# cursor.execute(sql)

# cursor = cursor.fetchall()
# for i in cursor:
#   print(i)

# localtime = time.localtime(time.time())
# localtime = datetime.time(11,24,30)
# localtime = time.time()
# localtime = time.asctime( time.localtime(time.time()) )

# print ("==================================")
# print ("Waktu lokal saat ini :",localtime)
# print ("==================================")

count = 5
for i in range(1,count+1):
  jam = datetime.datetime.now().hour
  menit = datetime.datetime.now().minute
  if menit + 1 :   
    pwk.sendwhatmsg( kontak , f"Login Daily Arknight",jam,menit+1,15,True,5)