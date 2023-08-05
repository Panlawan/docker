import network
import time
import dht
import ujson
from umqtt.simple import MQTTClient
import random


# MQTT Server Parameters
MQTT_CLIENT_ID = "micropython-weather-demo"
MQTT_BROKER = "good-moose.com"
MQTT_USER = "train1"
MQTT_PASSWORD = "train1"
MQTT_TOPIC = "wokwi-weather"
MQTT_TOPIC_SUB = "esp32sub"
DHT_PIN = 15

blink_interval = 5000
last_action_time = 0

# Function to connect to Wi-Fi
def connect_wifi(ssid, password):
    sta_if = network.WLAN(network.STA_IF)
    if not sta_if.isconnected():
        sta_if.active(True)
        sta_if.connect(ssid, password)
        while not sta_if.isconnected():
            print('.')
            time.sleep(1)
    print("Connected to Wi-Fi")

# Function to measure weather conditions
def measure_weather():
    
    return {
        "temp": random.randint(25, 30),
        "humidity": random.randint(50, 60),
    }

# Function to handle incoming MQTT messages
def sub_cb(topic, message):
    print("Received message from topic: ", topic)
    print("Message: ", message.decode('utf-8'))

def main():
    # Connect to Wi-Fi
    connect_wifi("Wokwi-GUEST", "")

    # Connect to MQTT broker
    client = MQTTClient(MQTT_CLIENT_ID, MQTT_BROKER, user=MQTT_USER, password=MQTT_PASSWORD)
    client.connect()

    # Subscribe to a topic to receive incoming messages
    client.set_callback(sub_cb)
    client.subscribe(MQTT_TOPIC_SUB)

    try:
        while True:
            global current_time
            global last_action_time
            current_time = time.ticks_ms()
            # Measure weather conditions

            if time.ticks_diff(current_time, last_action_time) > 2000:
                
                last_action_time = current_time

                weather_data = measure_weather()
                # Publish weather data to the MQTT broker
                message = ujson.dumps(weather_data)
                print("Publishing to MQTT topic {}: {}".format(MQTT_TOPIC, message))
                client.publish(MQTT_TOPIC, message)

            # Check for incoming MQTT messages
            client.check_msg()

            
    except KeyboardInterrupt:
        print("Exiting...")
    finally:
        # Disconnect from the MQTT broker
        client.disconnect()

if __name__ == "__main__":
    main()
