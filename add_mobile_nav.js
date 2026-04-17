/**
 * Script to add mobile navigation to all HTML pages
 * Run this with Node.js: node add_mobile_nav.js
 */

const fs = require('fs');
const path = require('path');

// Read the navigation component
const navigationHTML = fs.readFileSync('navigation.html', 'utf8');

// List of HTML files to update
const htmlFiles = [
    'index.html',
    'aboutus.html',
    'aboutus1.html',
    'solution.html',
    'contact.html',
    'australia.html',
    'bahrain.html',
    'bangladesh.html',
    'botswana.html',
    'canada.html',
    'egypt.html',
    'ghana.html',
    'India.html',
    'indonesia.html',
    'kenya.html',
    'malaysia.html',
    'oman.html',
    'Qatar.html',
    'Saudiarabia.html',
    'singapore.html',
    'thailand.html',
    'unitedarab.html',
    'us.html',
    'viethnam.html',
    'country.html',
    'country2.html',
    'demo1.html',
    'sloution1.html'
];

console.log('🚀 Adding mobile navigation to HTML files...\n');

htmlFiles.forEach(file => {
    try {
        if (!fs.existsSync(file)) {
            console.log(`⚠️  Skipped: ${file} (not found)`);
            return;
        }

        let content = fs.readFileSync(file, 'utf8');

        // Check if navigation already added
        if (content.includes('<!-- RESPONSIVE NAVIGATION COMPONENT')) {
            console.log(`✅ Already updated: ${file}`);
            return;
        }

        // Find the <header> tag and add mobile menu button after it
        const headerRegex = /(<header[^>]*>)/i;
        
        if (headerRegex.test(content)) {
            content = content.replace(headerRegex, `$1\n${navigationHTML}\n`);
            
            // Write back to file
            fs.writeFileSync(file, content, 'utf8');
            console.log(`✅ Updated: ${file}`);
        } else {
            console.log(`⚠️  No <header> found in: ${file}`);
        }
    } catch (error) {
        console.log(`❌ Error updating ${file}:`, error.message);
    }
});

console.log('\n✨ Mobile navigation update complete!');
