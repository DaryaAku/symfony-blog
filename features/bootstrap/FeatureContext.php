use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;

class FeatureContext extends MinkContext implements Context
{
    /**
     * @Given /^I am on "([^"]*)"$/
     */
    public function iAmOn($page)
    {
        $this->visitPath($page);
    }

    /**
     * @When /^I fill in "([^"]*)" with "([^"]*)"$/
     */
    public function iFillInField($field, $value)
    {
        $this->fillField($field, $value);
    }

    /**
     * @When /^I press "([^"]*)"$/
     */
    public function iPressButton($button)
    {
        $this->pressButton($button);
    }

    /**
     * @Then /^I should see "([^"]*)"$/
     */
    public function iShouldSeeText($text)
    {
        $this->assertPageContainsText($text);
    }

    /**
     * @Given /^a blog post exists with title "([^"]*)" and content "([^"]*)"$/
     */
    public function aBlogPostExists($title, $content)
    {
        // Создание записи в базе данных
        $entityManager = $this->getEntityManager();
        $post = new \App\Entity\Post();
        $post->setTitle($title);
        $post->setContent($content);
        $entityManager->persist($post);
        $entityManager->flush();
    }

    /**
     * @Given /^it has a comment "([^"]*)"$/
     */
    public function itHasAComment($commentText)
    {
        $entityManager = $this->getEntityManager();
        $post = $entityManager->getRepository(\App\Entity\Post::class)->findOneBy([]);
        $comment = new \App\Entity\Comment();
        $comment->setPost($post);
        $comment->setContent($commentText);
        $entityManager->persist($comment);
        $entityManager->flush();
    }

    /**
     * @Then /^I should not see "([^"]*)"$/
     */
    public function iShouldNotSeeText($text)
    {
        $this->assertPageNotContainsText($text);
    }

    private function getEntityManager()
    {
        return \App\Kernel::getContainer()->get('doctrine')->getManager();
    }
}
