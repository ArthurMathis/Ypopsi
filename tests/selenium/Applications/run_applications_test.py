import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

list_dir        = current_dir
parent_dir = os.path.dirname(list_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from Inscript.run_inscript_test import RunInscriptTest
# from List.run_list_test import run_list_test

ROSE  = '\033[38;2;255;192;203m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunApplicationsTest():
    write("Procédure de test des candidatures", ROSE, "title")
    
    RunInscriptTest()
    # run_list_test()
    
    write("Bloc de tests Validé", GREEN, "valid")

if __name__ == "__main__":
    RunApplicationsTest()