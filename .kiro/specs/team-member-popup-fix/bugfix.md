# Bugfix Requirements Document

## Introduction

Team member modal popups are not functioning on multiple country pages. When users click "Learn More" buttons on team member cards, the expected modal dialogs fail to appear. This affects 8 country pages (Singapore, Thailand, Malaysia, Australia, Indonesia, Vietnam, Canada, and US) and impacts user experience by preventing access to detailed team member information.

The root cause involves two distinct issues:
1. **ID Mismatch**: Button `data-bs-target` attributes reference generic modal IDs (e.g., `#modalGyan`) while the actual modal elements use country-specific IDs (e.g., `#modalGyanTH`, `#modalGyanUS`)
2. **Missing Modals**: Singapore and Malaysia pages have "Learn More" buttons but lack the corresponding modal HTML definitions entirely

## Bug Analysis

### Current Behavior (Defect)

1.1 WHEN a user clicks a "Learn More" button on a team member card on Thailand, US, Vietnam, Indonesia, or Canada pages THEN the system fails to display the modal popup because the button's `data-bs-target` references a generic modal ID that does not match the country-specific modal ID defined in the HTML

1.2 WHEN a user clicks a "Learn More" button on a team member card on Singapore or Malaysia pages THEN the system fails to display the modal popup because the modal HTML definition is completely missing from the page

1.3 WHEN a user clicks a "Learn More" button targeting `#modalGyan`, `#modalUdit`, or `#modalPriyanka` on affected country pages THEN the Bootstrap modal framework cannot find the matching modal element and no popup appears

### Expected Behavior (Correct)

2.1 WHEN a user clicks a "Learn More" button on a team member card on Thailand, US, Vietnam, Indonesia, or Canada pages THEN the system SHALL display the corresponding modal popup by ensuring the button's `data-bs-target` matches the country-specific modal ID (e.g., button targeting `#modalGyanTH` opens modal with id `modalGyanTH`)

2.2 WHEN a user clicks a "Learn More" button on a team member card on Singapore or Malaysia pages THEN the system SHALL display the corresponding modal popup by ensuring both the button references the correct modal ID AND the modal HTML definition exists on the page

2.3 WHEN a user clicks a "Learn More" button for any team member (Gyan Prakash Srivastava, Udit Gupta, or Priyanka Sondhi) on any affected country page THEN the system SHALL display a Bootstrap modal containing detailed information about that team member

### Unchanged Behavior (Regression Prevention)

3.1 WHEN a user clicks a "Learn More" button on team member cards on country pages that currently work correctly (e.g., UAE, Saudi Arabia) THEN the system SHALL CONTINUE TO display the modal popups as they currently do

3.2 WHEN modal popups are displayed on any country page THEN the system SHALL CONTINUE TO use the existing Bootstrap 5.3.2 modal functionality and CSS styling

3.3 WHEN users interact with other page elements on country pages (navigation, contact forms, other buttons) THEN the system SHALL CONTINUE TO function as they currently do without any changes

3.4 WHEN modal popups are closed (via close button, backdrop click, or ESC key) THEN the system SHALL CONTINUE TO behave as Bootstrap modals currently behave

---

## Bug Condition Specification

### Bug Condition Function

```pascal
FUNCTION isBugCondition(X)
  INPUT: X of type TeamMemberButtonClick
         WHERE X = {page: string, buttonTarget: string, modalExists: boolean, modalId: string}
  OUTPUT: boolean
  
  // Returns true when the bug condition is met
  RETURN (X.page IN ["singapore.html", "thailand.html", "malaysia.html", 
                     "australia.html", "indonesia.html", "viethnam.html", 
                     "canada.html", "us.html"])
         AND
         ((X.buttonTarget ≠ X.modalId AND X.modalExists = true)  // ID mismatch case
          OR
          (X.modalExists = false))  // Missing modal case
END FUNCTION
```

### Property Specification

```pascal
// Property: Fix Checking - Modal Display on Button Click
FOR ALL X WHERE isBugCondition(X) DO
  result ← handleTeamMemberButtonClick'(X)
  ASSERT result.modalDisplayed = true 
         AND result.modalId = X.buttonTarget
         AND result.modalContent.isVisible = true
END FOR
```

### Preservation Goal

```pascal
// Property: Preservation Checking - Existing Modal Functionality
FOR ALL X WHERE NOT isBugCondition(X) DO
  ASSERT handleTeamMemberButtonClick(X) = handleTeamMemberButtonClick'(X)
END FOR
```

**Key Definitions:**
- **F**: The original (unfixed) function - the current HTML pages with mismatched IDs and missing modals
- **F'**: The fixed function - the HTML pages after correcting button targets and adding missing modals
- **Counterexample**: Clicking "Learn More" on Gyan's card on `thailand.html` where button has `data-bs-target="#modalGyan"` but modal has `id="modalGyanTH"` results in no popup appearing
