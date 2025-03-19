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

    Scenario: Early pay out
        Given a claim was submitted
        And the claim was estimated at 500
        When the claim is paid out early for 275
        Then the balance is 225
        And the paid out is 275

    Scenario: Customer was not insured / not on cover
        Given a claim was submitted
        When the claim is rejected
        Then the balance is 0
        And the paid out is 0
