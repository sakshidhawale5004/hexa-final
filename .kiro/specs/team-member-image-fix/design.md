# Team Member Image Fix Bugfix Design

## Overview

This bugfix addresses incorrect team member image references across 6 country HTML files. The bug manifests in two ways: (1) external URLs to hexatp.com instead of local files, and (2) incorrect local file references showing the wrong person. The fix involves updating image `src` attributes in both team card sections and modal popup sections to reference the correct local image files that already exist in the workspace root directory.

## Glossary

- **Bug_Condition (C)**: The condition that triggers the bug - when a team member profile displays an image using an external hexatp.com URL or an incorrect local filename
- **Property (P)**: The desired behavior when the bug condition holds - the profile SHALL use the correct local image file from the workspace root
- **Preservation**: Existing team member profiles not listed in the bug report that must remain unchanged
- **Team Card**: The initial profile display section showing team member photo, name, and credentials
- **Modal Popup**: The detailed profile view that appears when clicking "Learn More" on a team card
- **Image Reference**: The `src` attribute value in an `<img>` tag that specifies the image file location

## Bug Details

### Bug Condition

The bug manifests when a team member profile in a country HTML file displays an image using either an external URL or an incorrect local filename. The HTML rendering engine either fetches images from external servers (creating dependency and performance issues) or displays the wrong person's photo (creating incorrect person-to-image mappings).

**Formal Specification:**
```
FUNCTION isBugCondition(input)
  INPUT: input of type HTMLImageElement
  OUTPUT: boolean
  
  RETURN (input.src STARTS_WITH 'https://hexatp.com/wp-content/uploads/' 
          AND input.alt IN ['George Mureithi', 'Mosttafa Shazzad Hasan', 'Nathaniel Owusu Ansah'])
         OR (input.src IN ['hitansu.png', 'yishu.png', 'nitin.png']
          AND input.alt IN ['Mohammad Taher Shaikh', 'Saniya Abbasi', 'Udit Gupta'])
END FUNCTION
```

### Examples

**External URL Issues:**
- **Kenya (kenya.html)**: George Mureithi profile uses `https://hexatp.com/wp-content/uploads/2022/05/6-1-1024x1024.png` instead of local `George Mureithi.jpg`
- **Bangladesh (bangladesh.html)**: Mosttafa Shazzad Hasan profile uses `https://hexatp.com/wp-content/uploads/2022/02/Shazzad-Hasan-980x980.png` instead of local `Mosttafa Shazzad Hasan.jpg`
- **Ghana (ghana.html)**: Nathaniel Owusu Ansah profile uses `https://hexatp.com/wp-content/uploads/2022/05/Picture1.png` instead of local `Nathaniel Owusu Ansah.jpg`

**Incorrect Local File Issues:**
- **UAE (unitedarab.html)**: Mohammad Taher Shaikh profile uses `hitansu.png` (wrong person) instead of `Mohammad Taher Shaikh new.jpg`
- **UAE (unitedarab.html)**: Saniya Abbasi profile uses `yishu.png` (wrong person) instead of `SANIYA.jpg`
- **Vietnam (viethnam.html)**: Udit Gupta profile uses `nitin.png` (wrong person) instead of `Udit Gupta.jpg`
- **US (us.html)**: Udit Gupta profile uses `nitin.png` (wrong person) instead of `Udit Gupta.jpg`

## Expected Behavior

### Preservation Requirements

**Unchanged Behaviors:**
- All team member profiles NOT listed in the bug report (Requirements 1.1-1.7) must continue to use their existing image references without modification
- Team card and modal popup structure, styling, and layout must remain unchanged
- All other profile details (name, credentials, title, professional descriptions) must remain unchanged
- Image dimensions (150x150px for team cards, 180px for modals) and styling (borders, object-fit) must remain unchanged
- Modal popup behavior, animations, and Bootstrap functionality must remain unchanged
- All other page content, navigation, and functionality must remain unchanged

**Scope:**
All HTML elements that do NOT involve the 7 specific image references listed in Requirements 2.1-2.7 should be completely unaffected by this fix. This includes:
- Other team member profiles on the same pages
- All page navigation, headers, footers, and styling
- JavaScript functionality for modals and interactions
- All other image references (flags, backgrounds, icons)

## Hypothesized Root Cause

Based on the bug description, the most likely issues are:

1. **Copy-Paste Errors**: The HTML files were likely created by copying from a template or another country page, and the image references were not updated to match the correct team member for that country

2. **External URL Migration Incomplete**: Some pages (Kenya, Bangladesh, Ghana) still reference the old external hexatp.com URLs and were not migrated to use the local image files that now exist in the workspace

3. **Filename Confusion**: The incorrect local file references (hitansu.png, yishu.png, nitin.png) suggest that image filenames were mixed up during a bulk update or migration, possibly because multiple team members' images were being updated simultaneously

4. **Dual Reference Points**: Each team member appears twice in the HTML (team card + modal popup), and both locations need to be updated, which may have been overlooked during manual edits

## Correctness Properties

Property 1: Bug Condition - Correct Local Image References

_For any_ team member profile image where the bug condition holds (external hexatp.com URL or incorrect local filename for the 7 specified cases), the fixed HTML SHALL reference the correct local image file from the workspace root directory, eliminating external dependencies and displaying the correct person's photo.

**Validates: Requirements 2.1, 2.2, 2.3, 2.4, 2.5, 2.6, 2.7**

Property 2: Preservation - Non-Buggy Profile Images

_For any_ team member profile image that is NOT one of the 7 specified cases in the bug report, the fixed HTML SHALL produce exactly the same image reference as the original HTML, preserving all existing functionality for non-affected team members.

**Validates: Requirements 3.1, 3.2, 3.3, 3.4, 3.5, 3.6**

## Fix Implementation

### Changes Required

Assuming our root cause analysis is correct:

**Files to Modify:**
1. `kenya.html` - George Mureithi (2 locations: team card + modal)
2. `bangladesh.html` - Mosttafa Shazzad Hasan (2 locations: team card + modal)
3. `ghana.html` - Nathaniel Owusu Ansah (2 locations: team card + modal)
4. `unitedarab.html` - Mohammad Taher Shaikh and Saniya Abbasi (4 locations: 2 team cards + 2 modals)
5. `viethnam.html` - Udit Gupta (2 locations: team card + modal)
6. `us.html` - Udit Gupta (2 locations: team card + modal)

**Specific Changes:**

1. **Kenya (kenya.html)**:
   - Team card: Change `src="https://hexatp.com/wp-content/uploads/2022/05/6-1-1024x1024.png"` to `src="George Mureithi.jpg"`
   - Modal popup: Change `src="https://hexatp.com/wp-content/uploads/2022/05/6-1-1024x1024.png"` to `src="George Mureithi.jpg"`

2. **Bangladesh (bangladesh.html)**:
   - Team card: Change `src="https://hexatp.com/wp-content/uploads/2022/02/Shazzad-Hasan-980x980.png"` to `src="Mosttafa Shazzad Hasan.jpg"`
   - Modal popup: Change `src="https://hexatp.com/wp-content/uploads/2022/02/Shazzad-Hasan-980x980.png"` to `src="Mosttafa Shazzad Hasan.jpg"`

3. **Ghana (ghana.html)**:
   - Team card: Change `src="https://hexatp.com/wp-content/uploads/2022/05/Picture1.png"` to `src="Nathaniel Owusu Ansah.jpg"`
   - Modal popup: Change `src="https://hexatp.com/wp-content/uploads/2022/05/Picture1.png"` to `src="Nathaniel Owusu Ansah.jpg"`

4. **UAE (unitedarab.html)**:
   - Mohammad Taher Shaikh team card: Change `src="hitansu.png"` to `src="Mohammad Taher Shaikh new.jpg"`
   - Mohammad Taher Shaikh modal: Change `src="hitansu.png"` to `src="Mohammad Taher Shaikh new.jpg"`
   - Saniya Abbasi team card: Change `src="yishu.png"` to `src="SANIYA.jpg"`
   - Saniya Abbasi modal: Change `src="yishu.png"` to `src="SANIYA.jpg"`

5. **Vietnam (viethnam.html)**:
   - Udit Gupta team card: Change `src="nitin.png"` to `src="Udit Gupta.jpg"`
   - Udit Gupta modal: Change `src="nitin.png"` to `src="Udit Gupta.jpg"`

6. **US (us.html)**:
   - Udit Gupta team card: Change `src="nitin.png"` to `src="Udit Gupta.jpg"`
   - Udit Gupta modal: Change `src="nitin.png"` to `src="Udit Gupta.jpg"`

**Implementation Notes:**
- Each change involves updating the `src` attribute value in an `<img>` tag
- The `alt` attribute should remain unchanged (it already contains the correct person's name)
- No changes to image styling, dimensions, or surrounding HTML structure
- Total of 14 image `src` attribute updates across 6 files

## Testing Strategy

### Validation Approach

The testing strategy follows a two-phase approach: first, verify the bug exists on unfixed code by observing incorrect images, then verify the fix works correctly and preserves existing behavior.

### Exploratory Bug Condition Checking

**Goal**: Confirm the bug exists BEFORE implementing the fix by visually inspecting the affected pages and verifying that incorrect images are displayed.

**Test Plan**: Open each of the 6 affected HTML files in a web browser and visually inspect the team member profiles to confirm:
1. External URLs are being used (check browser network tab for hexatp.com requests)
2. Incorrect person photos are displayed (compare alt text with actual image)

**Test Cases**:
1. **Kenya External URL Test**: Open kenya.html, verify George Mureithi shows external URL image (will fail on unfixed code - external dependency)
2. **Bangladesh External URL Test**: Open bangladesh.html, verify Mosttafa Shazzad Hasan shows external URL image (will fail on unfixed code - external dependency)
3. **Ghana External URL Test**: Open ghana.html, verify Nathaniel Owusu Ansah shows external URL image (will fail on unfixed code - external dependency)
4. **UAE Wrong Person Test**: Open unitedarab.html, verify Mohammad Taher Shaikh shows hitansu.png (wrong person) and Saniya Abbasi shows yishu.png (wrong person) (will fail on unfixed code - incorrect mapping)
5. **Vietnam Wrong Person Test**: Open viethnam.html, verify Udit Gupta shows nitin.png (wrong person) (will fail on unfixed code - incorrect mapping)
6. **US Wrong Person Test**: Open us.html, verify Udit Gupta shows nitin.png (wrong person) (will fail on unfixed code - incorrect mapping)

**Expected Counterexamples**:
- Browser network tab shows requests to hexatp.com for Kenya, Bangladesh, Ghana pages
- Visual inspection shows wrong person's photo for UAE (2 profiles), Vietnam (1 profile), US (1 profile)
- Possible causes: copy-paste errors, incomplete migration, filename confusion

### Fix Checking

**Goal**: Verify that for all team member profiles where the bug condition holds, the fixed HTML displays the correct local image file.

**Pseudocode:**
```
FOR ALL profile WHERE isBugCondition(profile.image) DO
  result := renderHTML_fixed(profile)
  ASSERT result.image.src = correctLocalFilename(profile.name)
  ASSERT result.image.loads_successfully = true
  ASSERT result.image.displays_correct_person = true
END FOR
```

**Test Plan**: After applying the fix, open each affected HTML file in a browser and verify:
1. No external hexatp.com requests in network tab
2. Correct person's photo displays for each profile
3. Both team card and modal popup show the same correct image

**Test Cases**:
1. **Kenya Fix Verification**: Verify George Mureithi displays `George Mureithi.jpg` in both team card and modal
2. **Bangladesh Fix Verification**: Verify Mosttafa Shazzad Hasan displays `Mosttafa Shazzad Hasan.jpg` in both team card and modal
3. **Ghana Fix Verification**: Verify Nathaniel Owusu Ansah displays `Nathaniel Owusu Ansah.jpg` in both team card and modal
4. **UAE Fix Verification**: Verify Mohammad Taher Shaikh displays `Mohammad Taher Shaikh new.jpg` and Saniya Abbasi displays `SANIYA.jpg` in both team cards and modals
5. **Vietnam Fix Verification**: Verify Udit Gupta displays `Udit Gupta.jpg` in both team card and modal
6. **US Fix Verification**: Verify Udit Gupta displays `Udit Gupta.jpg` in both team card and modal
7. **Image File Existence**: Verify all 6 local image files exist in workspace root and are accessible

### Preservation Checking

**Goal**: Verify that for all team member profiles where the bug condition does NOT hold, the fixed HTML produces the same image reference as the original HTML.

**Pseudocode:**
```
FOR ALL profile WHERE NOT isBugCondition(profile.image) DO
  ASSERT renderHTML_original(profile).image.src = renderHTML_fixed(profile).image.src
END FOR
```

**Testing Approach**: Manual inspection is recommended for preservation checking because:
- The number of affected files is small (6 files)
- Each file has a limited number of team member profiles to check
- Visual inspection can quickly confirm that non-affected profiles remain unchanged
- The changes are localized to specific `src` attributes, minimizing risk to other elements

**Test Plan**: After applying the fix, open each affected HTML file and verify that OTHER team members (not in the bug list) still display correctly with unchanged image references.

**Test Cases**:
1. **Kenya Preservation**: Verify any other team members on kenya.html (if present) continue to display correctly
2. **Bangladesh Preservation**: Verify any other team members on bangladesh.html (if present) continue to display correctly
3. **Ghana Preservation**: Verify any other team members on ghana.html (if present) continue to display correctly
4. **UAE Preservation**: Verify any other team members on unitedarab.html (if present) continue to display correctly
5. **Vietnam Preservation**: Verify any other team members on viethnam.html (if present) continue to display correctly
6. **US Preservation**: Verify any other team members on us.html (if present) continue to display correctly
7. **Page Layout Preservation**: Verify all 6 pages maintain their layout, styling, and functionality
8. **Modal Functionality Preservation**: Verify modal popups continue to work correctly for all team members

### Unit Tests

- Test that each of the 6 local image files exists in the workspace root directory
- Test that each image file is a valid image format (JPG/PNG) and can be loaded
- Test that HTML files contain the correct `src` attribute values after the fix
- Test that `alt` attributes remain unchanged and match the person's name

### Property-Based Tests

Not applicable for this bugfix. The bug involves specific hardcoded image references in HTML files, which are not suitable for property-based testing. Manual verification and unit tests are more appropriate.

### Integration Tests

- Test full page rendering for all 6 affected HTML files in a web browser
- Test that clicking "Learn More" on each affected team card opens the correct modal with the correct image
- Test that no external network requests to hexatp.com occur when loading the pages
- Test that all images display correctly with proper dimensions and styling
- Test across multiple browsers (Chrome, Firefox, Safari) to ensure consistent rendering
