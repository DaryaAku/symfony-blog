Feature: Blog management
  In order to manage blog posts
  As a user
  I need to be able to create, view, edit, delete, and interact with posts

  Scenario: Creating a new blog post
    Given I am on "/blog/new"
    When I fill in "title" with "Behat Test Post"
    And I fill in "content" with "This is a test post"
    And I press "Save"
    Then I should see "Post created successfully"

  Scenario: Viewing a blog post
    Given a blog post exists with title "Behat Test Post" and content "This is a test post"
    When I visit "/blog"
    Then I should see "Behat Test Post"

  Scenario: Editing a blog post
    Given a blog post exists with title "Behat Test Post"
    When I visit "/blog/edit/1"
    And I fill in "title" with "Updated Behat Test Post"
    And I press "Save"
    Then I should see "Post updated successfully"

  Scenario: Deleting a blog post
    Given a blog post exists with title "Behat Test Post"
    When I visit "/blog/delete/1"
    And I press "Confirm Delete"
    Then I should not see "Behat Test Post"

  Scenario: Searching for a blog post
    Given a blog post exists with title "Symfony Testing"
    When I visit "/blog"
    And I fill in "search" with "Symfony"
    And I press "Search"
    Then I should see "Symfony Testing"

  Scenario: Adding a comment to a blog post
    Given a blog post exists with title "Behat Test Post"
    When I visit "/blog/1"
    And I fill in "comment" with "This is a test comment"
    And I press "Add Comment"
    Then I should see "Comment added successfully"

  Scenario: Viewing comments on a blog post
    Given a blog post exists with title "Behat Test Post"
    And it has a comment "Nice post!"
    When I visit "/blog/1"
    Then I should see "Nice post!"

  Scenario: Liking a blog post
    Given a blog post exists with title "Behat Test Post"
    When I visit "/blog/1"
    And I press "Like"
    Then I should see "1 like"

  Scenario: Logging in as a user
    Given I am on "/login"
    When I fill in "email" with "user@example.com"
    And I fill in "password" with "password123"
    And I press "Login"
    Then I should see "Welcome, user@example.com"

  Scenario: Registering a new user
    Given I am on "/register"
    When I fill in "email" with "newuser@example.com"
    And I fill in "password" with "securepass"
    And I press "Register"
    Then I should see "Account created successfully"
