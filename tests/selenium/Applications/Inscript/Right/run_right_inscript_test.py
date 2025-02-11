import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

right_dir        = current_dir
inscript_dir     = os.path.dirname(right_dir)
applications_dir = os.path.dirname(inscript_dir)
parent_dir       = os.path.dirname(applications_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from RightRegistering.run_right_registering_test import RunRightRegisteringTest
from RightWith.run_right_with_test import RunRightWithTest

ROSE  = '\033[38;2;255;192;203m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunRightInscriptTest():
    write("Procédure de test de l'inscription des candidats - Succès", ROSE)
    
    RunRightRegisteringTest()
    RunRightWithTest()
    
    write("Bloc de tests Validé", GREEN, "valid")

if __name__ == "__main__":
    RunRightInscriptTest()