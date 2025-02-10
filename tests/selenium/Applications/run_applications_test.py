import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))
sys.path.append(current_dir)

from Inscript.run_inscript_test import RunInscriptTest
# from List.run_list_test import run_list_test

ORANGE = '\033[38;2;255;165;0m'
GREEN  = '\033[92m'
RESET  = '\033[0m'

def RunApplicationsTest():
    print(ORANGE + "==============================================" + RESET)
    print(ORANGE + "===== Procédure de test des candidatures =====" + RESET)

    RunInscriptTest()
    # run_list_test()
    
    print(GREEN + "============ Bloc de tests Validé ============" + RESET)
    print(GREEN + "==============================================" + RESET)

if __name__ == "__main__":
    RunApplicationsTest()