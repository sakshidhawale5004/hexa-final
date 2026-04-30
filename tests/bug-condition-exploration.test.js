/**
 * Bug Condition Exploration Test for Team Member Image Fix
 * 
 * **Validates: Requirements 1.1, 1.2, 1.3, 1.4, 1.5, 1.6, 1.7**
 * 
 * This test verifies the bug exists on unfixed code by checking that:
 * - External hexatp.com URLs are used instead of local files (Kenya, Bangladesh, Ghana)
 * - Incorrect local files are used showing wrong person (UAE, Vietnam, US)
 * 
 * EXPECTED OUTCOME: This test MUST FAIL on unfixed code - failure confirms the bug exists.
 * After the fix is implemented, this same test will PASS, confirming the bug is fixed.
 */

import { JSDOM } from 'jsdom';
import { readFileSync } from 'fs';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);
const rootDir = join(__dirname, '..');

// Test configuration mapping team members to their expected correct local files
const testCases = [
  {
    file: 'kenya.html',
    teamMember: 'George Mureithi',
    expectedSrc: 'George Mureithi.jpg',
    bugType: 'external-url',
    requirement: '1.1, 2.1'
  },
  {
    file: 'bangladesh.html',
    teamMember: 'Mosttafa Shazzad Hasan',
    expectedSrc: 'Mosttafa Shazzad Hasan.jpg',
    bugType: 'external-url',
    requirement: '1.2, 2.2'
  },
  {
    file: 'ghana.html',
    teamMember: 'Nathaniel Owusu Ansah',
    expectedSrc: 'Nathaniel Owusu Ansah.jpg',
    bugType: 'external-url',
    requirement: '1.3, 2.3'
  },
  {
    file: 'unitedarab.html',
    teamMember: 'Mohammad Taher Shaikh',
    expectedSrc: 'Mohammad Taher Shaikh new.jpg',
    bugType: 'incorrect-local',
    requirement: '1.4, 2.4'
  },
  {
    file: 'unitedarab.html',
    teamMember: 'Saniya Abbasi',
    expectedSrc: 'SANIYA.jpg',
    bugType: 'incorrect-local',
    requirement: '1.5, 2.5'
  },
  {
    file: 'viethnam.html',
    teamMember: 'Udit Gupta',
    expectedSrc: 'Udit Gupta.jpg',
    bugType: 'incorrect-local',
    requirement: '1.6, 2.6'
  },
  {
    file: 'us.html',
    teamMember: 'Udit Gupta',
    expectedSrc: 'Udit Gupta.jpg',
    bugType: 'incorrect-local',
    requirement: '1.7, 2.7'
  }
];

/**
 * Helper function to check if a bug condition exists for a team member
 * Returns true if the bug exists (external URL or incorrect local file)
 */
function isBugCondition(imgSrc, teamMember) {
  // Check for external hexatp.com URLs
  if (imgSrc.startsWith('https://hexatp.com/wp-content/uploads/')) {
    return true;
  }
  
  // Check for incorrect local files
  const incorrectFiles = ['hitansu.png', 'yishu.png', 'nitin.png'];
  if (incorrectFiles.some(file => imgSrc.includes(file))) {
    return true;
  }
  
  return false;
}

/**
 * Extract all image references for a specific team member from HTML
 * Returns array of {src, location} objects (team card and modal)
 */
function extractTeamMemberImages(dom, teamMember) {
  const images = [];
  const allImages = dom.window.document.querySelectorAll('img');
  
  allImages.forEach(img => {
    // Check if image has alt attribute matching team member
    if (img.alt === teamMember) {
      const location = img.closest('.team-card') ? 'team-card' : 
                      img.closest('.modal') ? 'modal' : 'unknown';
      images.push({
        src: img.src,
        alt: img.alt,
        location: location
      });
    }
    // Also check modal images by looking for team member name in nearby text
    else if (img.closest('.modal')) {
      const modal = img.closest('.modal');
      const modalText = modal.textContent;
      // Check if this modal contains the team member's name
      if (modalText.includes(teamMember)) {
        images.push({
          src: img.src,
          alt: img.alt || '(no alt)',
          location: 'modal'
        });
      }
    }
  });
  
  return images;
}

/**
 * Main test runner
 */
async function runBugConditionExplorationTest() {
  console.log('🔍 Bug Condition Exploration Test - Team Member Image Fix\n');
  console.log('=' .repeat(70));
  console.log('EXPECTED: This test MUST FAIL on unfixed code');
  console.log('FAILURE = Bug exists (correct outcome for exploration test)');
  console.log('=' .repeat(70) + '\n');
  
  let totalTests = 0;
  let failedTests = 0;
  const failures = [];
  
  for (const testCase of testCases) {
    const filePath = join(rootDir, testCase.file);
    
    try {
      // Read and parse HTML file
      const htmlContent = readFileSync(filePath, 'utf-8');
      const dom = new JSDOM(htmlContent);
      
      // Extract images for this team member
      const images = extractTeamMemberImages(dom, testCase.teamMember);
      
      if (images.length === 0) {
        console.log(`⚠️  WARNING: No images found for ${testCase.teamMember} in ${testCase.file}`);
        continue;
      }
      
      // Test each image reference (team card + modal)
      for (const image of images) {
        totalTests++;
        const testName = `${testCase.file} - ${testCase.teamMember} (${image.location})`;
        
        // Check if the image uses the correct local file
        const usesCorrectFile = image.src.includes(testCase.expectedSrc);
        
        if (!usesCorrectFile) {
          failedTests++;
          const bugExists = isBugCondition(image.src, testCase.teamMember);
          
          failures.push({
            testName,
            teamMember: testCase.teamMember,
            file: testCase.file,
            location: image.location,
            currentSrc: image.src,
            expectedSrc: testCase.expectedSrc,
            bugType: testCase.bugType,
            requirement: testCase.requirement,
            bugExists
          });
          
          console.log(`❌ FAIL: ${testName}`);
          console.log(`   Current:  ${image.src}`);
          console.log(`   Expected: ${testCase.expectedSrc}`);
          console.log(`   Bug Type: ${testCase.bugType}`);
          console.log(`   Requirement: ${testCase.requirement}\n`);
        } else {
          console.log(`✅ PASS: ${testName}`);
          console.log(`   Using correct file: ${testCase.expectedSrc}\n`);
        }
      }
      
    } catch (error) {
      console.error(`❌ ERROR reading ${testCase.file}: ${error.message}\n`);
      failedTests++;
      totalTests++;
    }
  }
  
  // Summary
  console.log('=' .repeat(70));
  console.log('TEST SUMMARY');
  console.log('=' .repeat(70));
  console.log(`Total Tests: ${totalTests}`);
  console.log(`Passed: ${totalTests - failedTests}`);
  console.log(`Failed: ${failedTests}\n`);
  
  if (failedTests > 0) {
    console.log('🐛 BUG CONDITION CONFIRMED - Counterexamples Found:\n');
    
    // Group failures by bug type
    const externalUrlBugs = failures.filter(f => f.bugType === 'external-url');
    const incorrectLocalBugs = failures.filter(f => f.bugType === 'incorrect-local');
    
    if (externalUrlBugs.length > 0) {
      console.log('📡 External URL Dependencies (hexatp.com):');
      externalUrlBugs.forEach(f => {
        console.log(`   • ${f.file}: ${f.teamMember} (${f.location})`);
        console.log(`     Current: ${f.currentSrc}`);
        console.log(`     Should be: ${f.expectedSrc}`);
      });
      console.log('');
    }
    
    if (incorrectLocalBugs.length > 0) {
      console.log('🖼️  Incorrect Local Files (Wrong Person):');
      incorrectLocalBugs.forEach(f => {
        console.log(`   • ${f.file}: ${f.teamMember} (${f.location})`);
        console.log(`     Current: ${f.currentSrc}`);
        console.log(`     Should be: ${f.expectedSrc}`);
      });
      console.log('');
    }
    
    console.log('=' .repeat(70));
    console.log('✅ EXPLORATION TEST RESULT: BUG EXISTS (Expected Outcome)');
    console.log('=' .repeat(70));
    console.log('\nThe test failures above confirm the bug exists on unfixed code.');
    console.log('After implementing the fix, re-run this test to verify it passes.\n');
    
    // Exit with code 1 to indicate test failure (which is expected for exploration)
    process.exit(1);
  } else {
    console.log('=' .repeat(70));
    console.log('⚠️  UNEXPECTED: All tests passed - Bug may already be fixed!');
    console.log('=' .repeat(70));
    console.log('\nThis exploration test expected to find bugs, but all images are correct.');
    console.log('Either the bug has already been fixed, or the test needs adjustment.\n');
    
    // Exit with code 0 since tests passed (but this is unexpected for exploration)
    process.exit(0);
  }
}

// Run the test
runBugConditionExplorationTest().catch(error => {
  console.error('Fatal error running test:', error);
  process.exit(1);
});
