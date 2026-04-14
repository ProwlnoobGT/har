import base64
import json
import urllib.request

key = 'GlobalToolsHAR'
payload = json.dumps({'method': 'login', 'input': ['dummykey'], 'ts': 0})
encoded = ''.join(chr(ord(payload[i]) ^ ord(key[i % len(key)])) for i in range(len(payload)))
blob = base64.b64encode(encoded.encode()).decode()
req = urllib.request.Request(
    'http://localhost:8000/framework/api.php',
    data=json.dumps({'blob': blob}).encode(),
    headers={'Content-Type': 'application/json'}
)
with urllib.request.urlopen(req) as resp:
    print(resp.status)
    print(resp.read().decode())
