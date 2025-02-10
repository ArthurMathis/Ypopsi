import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))
sys.path.append(current_dir)

from RightRegistering.run_right_registering_test import RunRightRegisteringTest
from RightWith.run_right_with_test import RunRightWithTest

ROSE  = '\033[38;2;255;192;203m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunRightInscriptTest():
    print(ROSE + "===== Procédure de test de l'inscription des candidats - Succès =====" + RESET)
    
    RunRightRegisteringTest()
    RunRightWithTest()
    
    print(GREEN + "===== Bloc de tests Validé =====" + RESET)

if __name__ == "__main__":
    RunRightInscriptTest()