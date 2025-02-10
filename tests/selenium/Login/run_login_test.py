import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))
sys.path.append(current_dir)

from Connect import TestConnect
from Disconnect import TestDisconnect
from ConnectFailure import TestConnectFailure

ROSE  = '\033[38;2;255;192;203m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunLoginTest():
    print(ROSE + "===== Procédure de test du login =====" + RESET)
    
    test = TestConnect()
    test.run()

    test = TestConnectFailure()
    test.run()

    test = TestDisconnect()
    test.run()
    
    print(GREEN + "===== Bloc de tests Validé =====" + RESET)

if __name__ == "__main__":
    RunLoginTest()