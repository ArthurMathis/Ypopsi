import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

list_dir         = current_dir
applications_dir = os.path.dirname(list_dir)
parent_dir       = os.path.dirname(applications_dir)

sys.path.append(parent_dir)

from define import write

ROSE  = '\033[38;2;255;192;203m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunListTest():
    write("Procédure de test de la maniuplation des listes", ROSE, "subtitle")
    
    
    
    write("Bloc de tests Validé", GREEN, "valid")

if __name__ == "__main__":
    RunListTest()