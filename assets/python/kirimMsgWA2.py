import sys
from yowsup.stacks import YowStack
from yowsup.layers import YowLayerEvent
from yowsup.layers.auth import AuthError
from yowsup.layers.network import YowNetworkLayer
from yowsup.layers.protocol_messages import YowProtocolLayer
from yowsup.layers.protocol_receipts import YowReceiptProtocolLayer
from yowsup.layers.protocol_acks import YowAckProtocolLayer

# Ambil kontak dari database
contacts = [
    {"name": "Faizal Agathon", "phone_number": "081914523696"}
]

# Kirim pesan ke setiap kontak
for contact in contacts:
    # Login ke akun WhatsApp
    stack = YowStack([
        YowLayerEvent(YowNetworkLayer),
        YowProtocolLayer,
        YowReceiptProtocolLayer,
        YowAckProtocolLayer
    ])
    stack.setProp(YowAuthenticationProtocolLayer.PROP_CREDENTIALS, (phone_number, password))
    stack.setProp(YowNetworkLayer.PROP_ENDPOINT, YowConstants.ENDPOINTS[0])
    stack.setProp(YowCoderLayer.PROP_DOMAIN, YowConstants.DOMAIN)
    stack.setProp(YowCoderLayer.PROP_RESOURCE, env.CURRENT_ENV.getResource())
    stack.broadcastEvent(YowLayerEvent(YowEventType.EVENT_AUTH))
    try:
        stack.loop(timeout=0.5, discrete=0.5)
    except AuthError as e:
        print("Authentication Error: %s" % e.message)
        sys.exit(1)

    # Kirim pesan
    message = "Hello " + contact["name"] + ", this is a test message."
    recipient = contact["phone_number"] + "@s.whatsapp.net"
    stack.getLayer(YowProtocolLayer).sendMessage(recipient, message)

print("Messages sent successfully!")
