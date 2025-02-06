import os
import sys

sys.path.append(os.path.abspath(os.path.dirname(__file__)))
sys.path.append(os.path.join(os.path.abspath(os.path.dirname(__file__)), 'Applications'))
sys.path.append(os.path.join(os.path.abspath(os.path.dirname(__file__)), 'Login'))

from Login.run_login_test import RunLoginTest
from Applications.run_applications_test import RunApplicationsTest

DARK_BLUE = '\033[38;2;255;192;203m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunAllTests():
    print(DARK_BLUE + "======================================================" + RESET)
    print(DARK_BLUE + "===== Lancement de la procédure complète de tests =====" + RESET)
    
    RunLoginTest()
    
    RunApplicationsTest()

    print(GREEN + "===== Procédure de tests Validée =====" + RESET)
    print(DARK_BLUE + "======================================================" + RESET)
    
if __name__ == "__main__":
    RunAllTests()