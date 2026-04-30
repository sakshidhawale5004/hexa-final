// Script to extract all team member information from the 6 affected HTML files
const fs = require('fs');
const path = require('path');

const files = [
  'kenya.html',
  'bangladesh.html',
  'ghana.html',
  'unitedarab.html',
  'viethnam.html',
  'us.html'
];

const buggyProfiles = [
  { file: 'kenya.html', name: 'George Mureithi', bugType: 'external URL' },
  { file: 'bangladesh.html', name: 'Mosttafa Shazzad Hasan', bugType: 'external URL' },
  { file: 'ghana.html', name: 'Nathaniel Owusu Ansah', bugType: 'external URL' },
  { file: 'unitedarab.html', name: 'Mohammad Taher Shaikh', bugType: 'wrong local file' },
  { file: 'unitedarab.html', name: 'Saniya Abbasi', bugType: 'wrong local file' },
  { file: 'viethnam.html', name: 'Udit Gupta', bugType: 'wrong local file' },
  { file: 'us.html', name: 'Udit Gupta', bugType: 'wrong local file' }
];

const results = {
  allProfiles: [],
  nonBuggyProfiles: []
};

files.forEach(file => {
  const filePath = path.join(process.cwd(), file);
  if (!fs.existsSync(filePath)) {
    console.log(`File not found: ${file}`);
    return;
  }

  const content = fs.readFileSync(filePath, 'utf-8');
  
  // Extract team cards (initial display)
  const teamCardRegex = /<div class="team-card">[\s\S]*?<img src="([^"]+)"[^>]*alt="([^"]+)"[\s\S]*?<h5>([^<]+)<\/h5>[\s\S]*?<p class="role">([^<]+)<\/p>/g;
  
  let match;
  while ((match = teamCardRegex.exec(content)) !== null) {
    const [, src, alt, name, role] = match;
    const profile = {
      file,
      name: name.trim(),
      alt: alt.trim(),
      role: role.trim(),
      teamCardSrc: src.trim(),
      isBuggy: buggyProfiles.some(b => b.file === file && b.name === alt.trim())
    };
    
    results.allProfiles.push(profile);
    
    if (!profile.isBuggy) {
      results.nonBuggyProfiles.push(profile);
    }
  }
});

console.log('\n=== ALL TEAM MEMBER PROFILES ===');
console.log(JSON.stringify(results.allProfiles, null, 2));

console.log('\n=== NON-BUGGY PROFILES (TO PRESERVE) ===');
console.log(JSON.stringify(results.nonBuggyProfiles, null, 2));

console.log(`\n=== SUMMARY ===`);
console.log(`Total profiles found: ${results.allProfiles.length}`);
console.log(`Buggy profiles: ${results.allProfiles.filter(p => p.isBuggy).length}`);
console.log(`Non-buggy profiles to preserve: ${results.nonBuggyProfiles.length}`);

// Write to file for test generation
fs.writeFileSync(
  path.join(__dirname, 'team-members-data.json'),
  JSON.stringify(results, null, 2)
);

console.log('\nData written to team-members-data.json');
