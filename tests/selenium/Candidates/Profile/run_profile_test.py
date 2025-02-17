import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

profile_dir    = current_dir
candidates_dir = os.path.dirname(profile_dir)
parent_dir     = os.path.dirname(candidates_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from BL.run_bl_test import RunBLTest
from Rating.run_rating_test import RunRatingTest

VIOLET = '\033[38;2;128;0;128m'
GREEN  = '\033[92m'
RESET  = '\033[0m'

def RunProfileTest():
    write("Procédure de test d'inscritpion d'une notation", VIOLET, "subtitle")
    
    RunBLTest()
    
    RunRatingTest()
    
    write("Procédure Validée", GREEN, "valid")
    
if __name__ == "__main__":
    RunProfileTest()