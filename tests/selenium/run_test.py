import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))
sys.path.append(current_dir)

from define import write
from Login.run_login_test import RunLoginTest
from Applications.run_applications_test import RunApplicationsTest

DARK_BLUE = '\033[38;2;0;0;139m' 
GREEN     = '\033[92m'
RESET     = '\033[0m'

def RunAllTests():
    write("Lancement de la procédure complète de tests", DARK_BLUE, "title")
    
    RunLoginTest()
    RunApplicationsTest()
    
    write("Procédure de tests Validée", GREEN, "valid")
    
if __name__ == "__main__":
    RunAllTests()