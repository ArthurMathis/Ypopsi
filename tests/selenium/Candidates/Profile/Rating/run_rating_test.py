import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

rating_dir     = current_dir
profile_dir    = os.path.dirname(rating_dir)
candidates_dir = os.path.dirname(profile_dir)
parent_dir     = os.path.dirname(candidates_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from InscriptRating1 import InscriptRating1
from InscriptRating2 import InscriptRating2
from InscriptRating3 import InscriptRating3
from InscriptRating4 import InscriptRating4
from InscriptRating5 import InscriptRating5

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunRatingTest():
    write("Procédure de test d'inscritpion d'une notation", VIOLET, "subtitle")
    
    test = InscriptRating1()
    test.run()
    
    test = InscriptRating2()
    test.run()
    
    test = InscriptRating3()
    test.run()
    
    test = InscriptRating4()
    test.run()
    
    test = InscriptRating5()
    test.run()
    
    write("Procédure Validée", GREEN, "valid")
    
if __name__ == "__main__":
    RunRatingTest()