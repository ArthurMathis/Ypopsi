import os
import sys
import time

current_dir = os.path.dirname(os.path.abspath(__file__))

rating_dir = current_dir
profile_dir = os.path.dirname(rating_dir)
parent_dir = os.path.dirname(profile_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from TestCandidates import TestCandidates

class InscriptRating3(TestCandidates):
    # * CONSTRUCTOR * #
    def __init__(self):
        """
        Initialise le test avec un nom descriptif
        """
        super().__init__("Test d'inscription de la notation 3/5 (candidat nécessaire)")
        
    # * RUN * #
    def run(self):
        """
        Exécute le test d'inscription à un entretien
        """
        self.writeName()
        driver = None
        
        try:
            driver = self.start()
            
            not_btn = self.find_element_by_css(driver, ".action_button.reverse_color.add_button")
            not_btn.click()
            
            self.setRating(driver, self.APP_CANDIDATES_RATING_3)
            
            valid_btn = self.find_element_by_css(driver, "button[type=\"submit\"]")
            valid_btn.click()
            
            self.writeSuccess()
            
        except Exception as e:
            self.writeError(e)
            
        finally:
            if driver:
                driver.quit()
                
if __name__ == "__main__":
    test = InscriptRating3()
    test.run()