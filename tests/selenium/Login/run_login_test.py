import os
import sys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from Connect import TestConnect
from Disconnect import TestDisconnect
from ConnectFailure import TestConnectFailure

def main():
    test = TestConnect()
    test.run()

    test = TestConnectFailure()
    test.run()

    test = TestDisconnect()
    test.run()

if __name__ == "__main__":
    main()