Feature: Claims moneys
    As a claims manager
    I want to record what I expect to and actually pay out for a claim
    So that I can prepare the business for the worst :-/

    Scenario: Simple claim and payout
        Given a claim was submitted
        And the claim was estimated at 500
        When the claim is settled for 275
        Then the balance is 0
        And the paid out is 275
