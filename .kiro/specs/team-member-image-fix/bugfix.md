# Bugfix Requirements Document

## Introduction

Country pages are using external image URLs or incorrect local image files for team member photos instead of the correct local image files that exist in the workspace. This creates dependency on external servers (hexatp.com), potential broken images, slower page load times, and incorrect person-to-image mappings. The bug affects 6 country HTML files and impacts 6 team members across Kenya, Bangladesh, Ghana, UAE, Vietnam, and US pages.

## Bug Analysis

### Current Behavior (Defect)

1.1 WHEN the Kenya page (kenya.html) displays George Mureithi's profile THEN the system uses external URL `https://hexatp.com/wp-content/uploads/2022/05/6-1-1024x1024.png` instead of local file

1.2 WHEN the Bangladesh page (bangladesh.html) displays Mosttafa Shazzad Hasan's profile THEN the system uses external URL `https://hexatp.com/wp-content/uploads/2022/02/Shazzad-Hasan-980x980.png` instead of local file

1.3 WHEN the Ghana page (ghana.html) displays Nathaniel Owusu Ansah's profile THEN the system uses external URL `https://hexatp.com/wp-content/uploads/2022/05/Picture1.png` instead of local file

1.4 WHEN the UAE page (unitedarab.html) displays Mohammad Taher Shaikh's profile THEN the system uses incorrect local file `hitansu.png` showing the wrong person

1.5 WHEN the UAE page (unitedarab.html) displays Saniya Abbasi's profile THEN the system uses incorrect local file `yishu.png` showing the wrong person

1.6 WHEN the Vietnam page (viethnam.html) displays Udit Gupta's profile THEN the system uses incorrect local file `nitin.png` showing the wrong person despite alt text saying "Udit Gupta"

1.7 WHEN the US page (us.html) displays Udit Gupta's profile THEN the system uses incorrect local file `nitin.png` showing the wrong person despite alt text saying "Udit Gupta"

### Expected Behavior (Correct)

2.1 WHEN the Kenya page (kenya.html) displays George Mureithi's profile THEN the system SHALL use local file `George Mureithi.jpg` in both the team card and modal popup

2.2 WHEN the Bangladesh page (bangladesh.html) displays Mosttafa Shazzad Hasan's profile THEN the system SHALL use local file `Mosttafa Shazzad Hasan.jpg` in both the team card and modal popup

2.3 WHEN the Ghana page (ghana.html) displays Nathaniel Owusu Ansah's profile THEN the system SHALL use local file `Nathaniel Owusu Ansah.jpg` in both the team card and modal popup

2.4 WHEN the UAE page (unitedarab.html) displays Mohammad Taher Shaikh's profile THEN the system SHALL use local file `Mohammad Taher Shaikh new.jpg` in both the team card and modal popup

2.5 WHEN the UAE page (unitedarab.html) displays Saniya Abbasi's profile THEN the system SHALL use local file `SANIYA.jpg` in both the team card and modal popup

2.6 WHEN the Vietnam page (viethnam.html) displays Udit Gupta's profile THEN the system SHALL use local file `Udit Gupta.jpg` in both the team card and modal popup

2.7 WHEN the US page (us.html) displays Udit Gupta's profile THEN the system SHALL use local file `Udit Gupta.jpg` in both the team card and modal popup

### Unchanged Behavior (Regression Prevention)

3.1 WHEN any country page displays team members not listed in the bug report THEN the system SHALL CONTINUE TO use their existing image references without modification

3.2 WHEN any country page displays team member profiles THEN the system SHALL CONTINUE TO show both the team card image and modal popup image

3.3 WHEN any country page displays team member information THEN the system SHALL CONTINUE TO show all other profile details (name, credentials, title) unchanged

3.4 WHEN any country page loads THEN the system SHALL CONTINUE TO display the page layout, styling, and functionality unchanged

3.5 WHEN team member images are displayed THEN the system SHALL CONTINUE TO maintain the same image dimensions and aspect ratios as currently configured

3.6 WHEN users interact with team member cards THEN the system SHALL CONTINUE TO open modal popups with the same behavior and animations
