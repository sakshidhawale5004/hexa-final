# Mobile Header Logo Fix Design

## Overview

The mobile header logo displays a question mark (?) instead of the HexaTP branding on mobile devices. This occurs because the text-based logo implementation (`<div class="logo">HEXA<span>TP</span></div>`) fails to render properly on mobile browsers, likely due to font rendering issues or missing font fallbacks. The fix will replace the text-based logo with an image-based logo using the existing LOGO.jpeg file, while maintaining desktop/tablet functionality and preserving all other header elements and behaviors.

## Glossary

- **Bug_Condition (C)**: The condition that triggers the bug - when the header is rendered on mobile devices (viewport width ≤ 768px)
- **Property (P)**: The desired behavior - the header should display the HexaTP logo image instead of a question mark
- **Preservation**: Desktop and tablet logo display, header layout, navigation functionality, and all other page elements must remain unchanged
- **Text-based logo**: The current implementation using `<div class="logo">HEXA<span>TP</span></div>` with CSS styling
- **Image-based logo**: The replacement implementation using `<img src="LOGO.jpeg" alt="HexaTP Logo" />` 
- **Header element**: The fixed header component at the top of all pages containing logo, navigation, and CTA button
- **Mobile viewport**: Screen width ≤ 768px (standard mobile breakpoint used in the existing CSS)

## Bug Details

### Bug Condition

The bug manifests when the website header is rendered on mobile devices with viewport width ≤ 768px. The text-based logo element fails to display the "HEXATP" text and instead shows a question mark symbol (?), likely due to font rendering issues, missing font fallbacks, or CSS specificity problems on mobile browsers.

**Formal Specification:**
```
FUNCTION isBugCondition(input)
  INPUT: input of type PageRenderContext
  OUTPUT: boolean
  
  RETURN input.viewportWidth <= 768
         AND input.element == "header .logo"
         AND input.logoType == "text-based"
         AND logoDisplaysQuestionMark(input)
END FUNCTION
```

### Examples

- **Mobile Chrome (375px width)**: Header displays "?" instead of "HEXATP" logo
- **Mobile Safari (414px width)**: Header displays "?" instead of "HEXATP" logo  
- **Mobile Firefox (360px width)**: Header displays "?" instead of "HEXATP" logo
- **Tablet (768px width)**: Logo displays correctly (edge case - should continue working)
- **Desktop (1920px width)**: Logo displays correctly (should remain unchanged)

## Expected Behavior

### Preservation Requirements

**Unchanged Behaviors:**
- Desktop logo display (viewport width > 768px) must continue to work exactly as before
- Tablet logo display (viewport width 769px - 1024px) must continue to work exactly as before
- Header layout, positioning, and styling must remain unchanged across all devices
- Navigation menu functionality (desktop dropdown, mobile hamburger menu) must remain unchanged
- Header CTA button ("Get Started") must remain unchanged
- Logo positioning within the header must remain consistent
- Logo click behavior (if any link exists) must remain unchanged

**Scope:**
All inputs that do NOT involve mobile viewport rendering (viewport width > 768px) should be completely unaffected by this fix. This includes:
- Desktop browser rendering (viewport width > 1024px)
- Tablet browser rendering (viewport width 769px - 1024px)
- All other page elements outside the header logo
- All JavaScript functionality for navigation and interactions

## Hypothesized Root Cause

Based on the bug description and code analysis, the most likely issues are:

1. **Font Rendering Failure**: The custom font (Poppins) may not be loading properly on mobile devices, causing the browser to display a fallback character (?) when the font is unavailable.

2. **CSS Specificity Issues**: Mobile-specific CSS rules may be overriding the logo styles in unexpected ways, causing the text content to not render properly.

3. **Character Encoding Issues**: The text content "HEXA<span>TP</span>" may have encoding issues on mobile browsers that cause it to display as a question mark.

4. **Font Weight/Style Mismatch**: The font-weight: 800 and text-transform: uppercase may not be supported properly on mobile devices for the Poppins font, causing rendering failures.

## Correctness Properties

Property 1: Bug Condition - Mobile Logo Image Display

_For any_ page render where the viewport width is ≤ 768px and the header logo element is rendered, the fixed implementation SHALL display the LOGO.jpeg image file with proper sizing, positioning, and alt text, ensuring the HexaTP branding is visible instead of a question mark.

**Validates: Requirements 2.1, 2.2, 2.3**

Property 2: Preservation - Desktop/Tablet Logo Display

_For any_ page render where the viewport width is > 768px (desktop and tablet devices), the fixed implementation SHALL produce exactly the same logo display as the original implementation, preserving the existing text-based or image-based logo appearance and all styling.

**Validates: Requirements 3.1, 3.2, 3.3, 3.4**

## Fix Implementation

### Changes Required

Assuming our root cause analysis is correct (font rendering failure on mobile), the fix will replace the text-based logo with an image-based logo for all devices.

**Files to Modify**: All HTML files in the project (24 files total based on file tree)

**Element to Replace**: `<div class="logo">HEXA<span>TP</span></div>`

**Specific Changes**:

1. **Replace Logo HTML Element**: 
   - **Old**: `<div class="logo">HEXA<span>TP</span></div>`
   - **New**: `<img src="LOGO.jpeg" alt="HexaTP - Transfer Pricing Simplified" class="logo-img" />`
   - This replaces the text-based logo with an image-based logo using the existing LOGO.jpeg file

2. **Add CSS for Logo Image Sizing**:
   - Add new CSS rule for `.logo-img` class to control image dimensions
   - Desktop: `height: 40px; width: auto;` (maintains aspect ratio)
   - Mobile: `height: 30px; width: auto;` (slightly smaller for mobile header)
   - Add `display: block;` to ensure proper rendering

3. **Update Mobile Responsive CSS**:
   - Ensure `.logo-img` has appropriate sizing in mobile breakpoint (@media max-width: 768px)
   - Adjust header padding if needed to accommodate image logo

4. **Remove or Update Existing .logo CSS**:
   - The existing `.logo` class styles (font-weight, font-size, text-transform) will no longer apply
   - Keep the class definition for backward compatibility but it won't affect the image

5. **Verify Logo File Path**:
   - Ensure LOGO.jpeg is in the root directory (confirmed: hexatp-main/LOGO.jpeg exists)
   - All HTML files reference it as `src="LOGO.jpeg"` (relative path from HTML file location)

### CSS Changes Required

Add to the `<style>` section in each HTML file (after existing `.logo` definition):

```css
.logo-img {
    height: 40px;
    width: auto;
    display: block;
}

@media (max-width: 768px) {
    .logo-img {
        height: 30px;
        width: auto;
    }
}
```

## Testing Strategy

### Validation Approach

The testing strategy follows a two-phase approach: first, surface counterexamples that demonstrate the bug on unfixed code, then verify the fix works correctly and preserves existing behavior.

### Exploratory Bug Condition Checking

**Goal**: Surface counterexamples that demonstrate the bug BEFORE implementing the fix. Confirm or refute the root cause analysis (font rendering failure). If we refute, we will need to re-hypothesize.

**Test Plan**: Manually test the current website on actual mobile devices and mobile browser emulators to observe the question mark display. Document the exact conditions under which the bug occurs.

**Test Cases**:
1. **Mobile Chrome Test**: Open website on mobile Chrome (375px width) - observe question mark in header (will fail on unfixed code)
2. **Mobile Safari Test**: Open website on mobile Safari (414px width) - observe question mark in header (will fail on unfixed code)
3. **Mobile Firefox Test**: Open website on mobile Firefox (360px width) - observe question mark in header (will fail on unfixed code)
4. **Tablet Edge Case**: Open website on tablet (768px width) - verify logo displays correctly (should pass on unfixed code)
5. **Desktop Baseline**: Open website on desktop (1920px width) - verify logo displays correctly (should pass on unfixed code)

**Expected Counterexamples**:
- Mobile browsers display "?" instead of "HEXATP" text
- Possible causes: font not loading, CSS override, encoding issue, font-weight not supported

### Fix Checking

**Goal**: Verify that for all inputs where the bug condition holds (mobile viewport), the fixed function produces the expected behavior (displays logo image).

**Pseudocode:**
```
FOR ALL pageRender WHERE isBugCondition(pageRender) DO
  result := renderHeader_fixed(pageRender)
  ASSERT logoImageDisplayed(result)
  ASSERT logoImageSource(result) == "LOGO.jpeg"
  ASSERT logoImageAltText(result) == "HexaTP - Transfer Pricing Simplified"
  ASSERT logoImageVisible(result) == true
END FOR
```

**Test Plan**: After implementing the fix, test on multiple mobile devices and viewport sizes to verify the logo image displays correctly.

**Test Cases**:
1. **Mobile Chrome (375px)**: Verify LOGO.jpeg displays with correct sizing
2. **Mobile Safari (414px)**: Verify LOGO.jpeg displays with correct sizing
3. **Mobile Firefox (360px)**: Verify LOGO.jpeg displays with correct sizing
4. **Small Mobile (320px)**: Verify LOGO.jpeg displays without overflow
5. **Large Mobile (428px)**: Verify LOGO.jpeg displays with correct sizing

### Preservation Checking

**Goal**: Verify that for all inputs where the bug condition does NOT hold (desktop/tablet viewport), the fixed function produces the same result as the original function.

**Pseudocode:**
```
FOR ALL pageRender WHERE NOT isBugCondition(pageRender) DO
  ASSERT renderHeader_original(pageRender) ≈ renderHeader_fixed(pageRender)
  ASSERT logoDisplayCorrectly(pageRender)
  ASSERT headerLayoutUnchanged(pageRender)
END FOR
```

**Testing Approach**: Visual regression testing is recommended for preservation checking because:
- It captures the exact visual appearance of the header across different viewport sizes
- It detects any unintended layout shifts or styling changes
- It provides strong guarantees that desktop/tablet behavior is unchanged

**Test Plan**: Observe behavior on UNFIXED code first for desktop/tablet rendering, then compare with FIXED code to ensure identical appearance.

**Test Cases**:
1. **Desktop Logo Display (1920px)**: Verify logo appears identical to original (image vs text comparison)
2. **Tablet Logo Display (1024px)**: Verify logo appears identical to original
3. **Header Layout Preservation**: Verify header padding, alignment, and spacing remain unchanged
4. **Navigation Menu Preservation**: Verify desktop dropdown and mobile hamburger menu continue to work
5. **CTA Button Preservation**: Verify "Get Started" button remains unchanged in position and styling

### Unit Tests

- Test logo image loads successfully on mobile viewport (375px, 414px, 768px)
- Test logo image has correct alt text for accessibility
- Test logo image has correct dimensions (height: 30px on mobile, 40px on desktop)
- Test logo image path is correct (LOGO.jpeg in root directory)
- Test header layout remains unchanged after logo replacement

### Property-Based Tests

Not applicable for this fix - the bug is deterministic based on viewport width, and property-based testing would not provide additional value over manual testing and visual regression testing.

### Integration Tests

- Test full page load on mobile device with logo image displayed correctly
- Test navigation between pages maintains logo display consistency
- Test mobile menu open/close with logo remaining visible
- Test page resize from desktop to mobile maintains logo display
- Test all 24 HTML pages display logo correctly on mobile and desktop
