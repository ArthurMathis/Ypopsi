import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))
sys.path.append(current_dir)

from Right.run_right_inscript_test import RunRightInscriptTest
from Wrong.run_wrong_inscript_test import RunWrongInscriptTest

ROSE  = '\033[38;2;255;192;203m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunInscriptTest():
    print(ROSE + "===== Procédure de test de l'inscription des candidats =====" + RESET)
    
    RunRightInscriptTest()
    RunWrongInscriptTest()
    
    print(GREEN + "===== Bloc de tests Validé =====" + RESET)

if __name__ == "__main__":
    RunInscriptTest()