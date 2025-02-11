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

class InscriptRating1(TestCandidates):
    # * CONSTRUCTOR * #
    def __init__(self):
        """
        Initialise le test avec un nom descriptif
        """
        super().__init__("Test d'inscription de la notation 1/5 (candidat nécessaire)")
        
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
            
            self.setRating(driver, self.APP_CANDIDATES_RATING_1)
            
            time.sleep(self.SLEEP_TIME)
            
            valid_btn = self.find_element_by_css(driver, "button[type=\"submit\"]")
            valid_btn.click()
            
            rate = self.find_element_by_css(driver, "#rating_bubble .number")
            html_content = rate.text
            rate_html = html_content.removesuffix("/5")
            
            if rate_html == str(self.APP_CANDIDATES_RATING_1):
                self.writeSuccess()
            else:
                raise Exception(f"Nouvelle notation non effective. Valeur : {rate_html} ; valeur attendue : {self.APP_CANDIDATES_RATING_1}")

            
        except Exception as e:
            self.writeError(e)
            
        finally:
            if driver:
                driver.quit()
                
if __name__ == "__main__":
    test = InscriptRating1()
    test.run()