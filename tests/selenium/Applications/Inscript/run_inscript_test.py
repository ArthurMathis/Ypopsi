import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

inscript_dir    = current_dir
applications_dir = os.path.dirname(inscript_dir)
parent_dir      = os.path.dirname(applications_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from Right.run_right_inscript_test import RunRightInscriptTest
from Wrong.run_wrong_inscript_test import RunWrongInscriptTest

ROSE  = '\033[38;2;255;192;203m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunInscriptTest():
    write("Procédure de test de l'inscription des candidats", ROSE, "subtitle")
    
    RunRightInscriptTest()
    RunWrongInscriptTest()
    
    write("Bloc de tests Validé", GREEN, "valid")

if __name__ == "__main__":
    RunInscriptTest()