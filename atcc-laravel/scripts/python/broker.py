#Comunicação com Broker#
connected = False
finalizar = False
novaMsg = None
    
# Definição dos eventos de comunicação
def on_connect(client, userdata, flags, rc):
    rc = rc

def on_message(client, obj, message):
    msgRecebida = message.payload.decode('utf8')
    if(msgRecebida.startswith('tS')):
        updatePinState(msgRecebida)

def on_publish(client, obj, mid):
    print("mid: " + str(mid))

def on_subscribe(client, obj, mid, granted_qos):
    print("Subscribed:" + str(mid) + " " + str(granted_qos))

def on_log(client, obj, level, string):
    print(string)

mqttcServer = mqtt.Client()
# Atribui os eventos de comunicação com sua respectiva sub-rotina
mqttcServer.on_message = on_message
mqttcServer.on_connect = on_connect
mqttcServer.on_publish = on_publish
mqttcServer.on_subscribe = on_subscribe

# Realiza a conexão ao broker
mqttcServer.username_pw_set("acmegerenciamento", "aio_zhnK45p6HbSYu3eTNp8criSDL51T") #Definição de usuário e senha da plataforma AdafruitIO
mqttcServer.connect('io.adafruit.com', 1883) #Definição do endereço e porta a ser utilizada do serviço MQTT

# Inicia a inscrição (subscribe), com QoS level 0
mqttcServer.subscribe('acmegerenciamento/feeds/ciar.ciar-ts', 0)

sleep(1.5)

mqttcServer.publish('acmegerenciamento/feeds/ciar.ciar-ta', "tA1:0:1:13:2")
sleep(3.0)
mqttcServer.publish('acmegerenciamento/feeds/ciar.ciar-ta', "tA1:0:2:12:4")
sleep(3.0)

mqttcServer.loop_start() #NOVO

def sendData(data):
    mqttcServer.publish('acmegerenciamento/feeds/ciar.ciar-ta', data)

#Fim Comunicação com Broker#