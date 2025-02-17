import os
import sys
import time

current_dir = os.path.dirname(os.path.abspath(__file__))

bl_dir = current_dir
profile_dir = os.path.dirname(bl_dir)
parent_dir = os.path.dirname(profile_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from TestCandidates import TestCandidates

class InscriptBLa(TestCandidates):
    # * CONSTRUCTOR * #
    def __init__(self):
        """
        Initialise le test avec un nom descriptif
        """
        super().__init__("Test d'inscription de la BL a (candidat nécessaire)")
        
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
            
            self.setBL(driver, self.APP_CANDIDATES_BL_A)
            self.setBL(driver, self.APP_CANDIDATES_BL_B, False)
            self.setBL(driver, self.APP_CANDIDATES_BL_C, False)
            
            time.sleep(self.SLEEP_TIME)
            
            valid_btn = self.find_element_by_css(driver, "button[type=\"submit\"]")
            valid_btn.click()
            
            time.sleep(self.SLEEP_TIME)
            
            valid = self.getBL(driver, [ self.APP_CANDIDATES_BL_A ])
            valid = valid and self.getBL(driver, [ self.APP_CANDIDATES_BL_B, self.APP_CANDIDATES_BL_B ], False)
            
            if valid: 
                self.writeSuccess()
            else:
                raise Exception(f"Nouvelle BL non effective.")
            
        except Exception as e:
            self.writeError(e)
            
        finally:
            if driver:
                driver.quit()
                
if __name__ == "__main__":
    test = InscriptBLa()
    test.run()