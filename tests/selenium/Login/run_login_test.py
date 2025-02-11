import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

list_dir        = current_dir
parent_dir = os.path.dirname(list_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from Connect import TestConnect
from Disconnect import TestDisconnect
from ConnectFailure import TestConnectFailure

ROSE  = '\033[38;2;255;192;203m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunLoginTest():
    write("Procédure de test du login", ROSE, "subtitle")
    
    test = TestConnect()
    test.run()

    test = TestConnectFailure()
    test.run()

    test = TestDisconnect()
    test.run()
    
    write("Bloc de tests Validé", GREEN, "valid")

if __name__ == "__main__":
    RunLoginTest()