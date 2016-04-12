import redis
import signal
import json
import sys
import time

def message_handler(message):
  print('REDIS: ', message['data'])
  json_from_redis = json.loads(message['data'])
  print('Sending Salt event.')
  import salt.client
  caller = salt.client.Caller()
#  caller.sminion.functions['event.send']('demeter/frontapi/event', json_from_redis )
  caller.cmd('event.send', 'demeter/frontapi/event', json_from_redis )
  print('Salt event sent.')


r = redis.StrictRedis(host='localhost', port=6379, db=0)
pubsub_object = r.pubsub(ignore_subscribe_messages=True)
pubsub_object.subscribe(**{'demeter':message_handler})
redis_listener_thread = pubsub_object.run_in_thread(sleep_time=0.001)

print('Redis listener started.')

def stopping_everything(signal, frame):
  print('Closing connection to redis.')
  redis_listener_thread.stop()
  pubsub_object.close()
  sys.exit(0)


while True:
  signal.signal(signal.SIGINT, stopping_everything)
  time.sleep(1)
