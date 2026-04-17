# How to Create a Pull Request on GitHub

## 📋 Step-by-Step Guide

### **Step 1: Go to the Pull Requests Page**

1. Open your browser
2. Navigate to:
   ```
   https://github.com/digicoyotes-web/hexatp-1/pulls
   ```

3. You should see the Pull Requests page with a green **"New pull request"** button

**Screenshot Reference:**
```
┌─────────────────────────────────────────────────────────┐
│ digicoyotes-web / hexatp-1                              │
├─────────────────────────────────────────────────────────┤
│ Code  Issues  Pull requests  Discussions  Actions  Wiki │
│                                                          │
│ [New pull request] ← Click this button                  │
└─────────────────────────────────────────────────────────┘
```

---

### **Step 2: Click "New pull request" Button**

Click the green **"New pull request"** button in the top right

**What you'll see:**
```
┌─────────────────────────────────────────────────────────┐
│ Compare changes                                         │
├─────────────────────────────────────────────────────────┤
│ Choose two branches to see what's changed or to start   │
│ a new pull request.                                     │
└─────────────────────────────────────────────────────────┘
```

---

### **Step 3: Select Base Branch**

1. Look for the **"base:"** dropdown (left side)
2. Click on it
3. Select **"main"**

**Visual:**
```
┌──────────────────────────────────────────────────────────┐
│ base: [main ▼]  ←  Click here and select "main"         │
└──────────────────────────────────────────────────────────┘
```

---

### **Step 4: Select Compare Branch**

1. Look for the **"compare:"** dropdown (right side)
2. Click on it
3. Select **"feature/database-consultation-system"**

**Visual:**
```
┌──────────────────────────────────────────────────────────┐
│ compare: [feature/database-consultation-system ▼]       │
│          ← Click here and select this branch            │
└──────────────────────────────────────────────────────────┘
```

---

### **Step 5: Review Changes**

After selecting both branches, you'll see:
- List of commits
- Files changed
- Additions and deletions

**You should see:**
```
✅ 6 commits
✅ 11 files changed
✅ 2,000+ lines added
```

---

### **Step 6: Click "Create pull request"**

Click the green **"Create pull request"** button

**Visual:**
```
┌──────────────────────────────────────────────────────────┐
│ [Create pull request] ← Click this button               │
└──────────────────────────────────────────────────────────┘
```

---

### **Step 7: Fill in PR Title**

In the title field, enter:

```
feat: Add database connectivity and mobile responsive consultation system
```

**Visual:**
```
┌──────────────────────────────────────────────────────────┐
│ Title:                                                   │
│ [feat: Add database connectivity and mobile responsive] │
│  [consultation system                                  ] │
└──────────────────────────────────────────────────────────┘
```

---

### **Step 8: Fill in PR Description**

In the description field, paste:

```markdown
## Summary
This PR adds a complete consultation booking system with database connectivity and mobile responsiveness.

## Changes
- ✅ Database connectivity with prepared statements (SQL injection prevention)
- ✅ Mobile responsive design (5 breakpoints)
- ✅ Consultation form with calendar and time slots
- ✅ Admin dashboard for managing consultations
- ✅ Comprehensive documentation

## Files Changed
- contact.html - Enhanced with mobile responsiveness
- save_inquiry.php - Improved with security and validation
- db_config.php - New database configuration
- setup_database.php - New database initialization script
- admin_consultations.php - New admin dashboard
- Documentation files (README, guides, etc.)

## Testing
- ✅ Database connection verified
- ✅ Form submission tested
- ✅ Mobile responsiveness tested on all breakpoints
- ✅ Admin dashboard verified
- ✅ Security features validated

## Deployment
1. Run setup_database.php to initialize database
2. Test consultation form
3. Verify admin dashboard

## Related Issues
Closes #[issue number if applicable]
```

**Visual:**
```
┌──────────────────────────────────────────────────────────┐
│ Description:                                             │
│ ┌────────────────────────────────────────────────────┐  │
│ │ ## Summary                                         │  │
│ │ This PR adds a complete consultation booking...   │  │
│ │                                                    │  │
│ │ ## Changes                                         │  │
│ │ - ✅ Database connectivity...                     │  │
│ │ - ✅ Mobile responsive design...                  │  │
│ │ ...                                                │  │
│ └────────────────────────────────────────────────────┘  │
└──────────────────────────────────────────────────────────┘
```

---

### **Step 9: Add Labels (Optional)**

1. Click **"Labels"** on the right side
2. Select relevant labels:
   - `enhancement`
   - `documentation`
   - `mobile`
   - `database`

**Visual:**
```
┌──────────────────────────────────────────────────────────┐
│ Labels:                                                  │
│ [enhancement] [documentation] [mobile] [database]        │
└──────────────────────────────────────────────────────────┘
```

---

### **Step 10: Add Assignees (Optional)**

1. Click **"Assignees"** on the right side
2. Select team members who should review

**Visual:**
```
┌──────────────────────────────────────────────────────────┐
│ Assignees:                                               │
│ [Select assignees...]                                    │
└──────────────────────────────────────────────────────────┘
```

---

### **Step 11: Create the Pull Request**

Click the green **"Create pull request"** button at the bottom

**Visual:**
```
┌──────────────────────────────────────────────────────────┐
│ [Create pull request] ← Final click!                    │
└──────────────────────────────────────────────────────────┘
```

---

## ✅ Success!

After clicking "Create pull request", you'll see:

```
┌──────────────────────────────────────────────────────────┐
│ #1 feat: Add database connectivity and mobile...        │
│ Open                                                     │
├──────────────────────────────────────────────────────────┤
│ Your PR has been created successfully!                  │
│                                                          │
│ ✅ All checks passed                                    │
│ ✅ Ready for review                                     │
│ ✅ Ready to merge                                       │
└──────────────────────────────────────────────────────────┘
```

---

## 📊 What Happens Next

### **1. Automated Checks**
- GitHub runs automated tests
- Code quality checks
- Security scans

### **2. Code Review**
- Team members review the code
- Leave comments
- Request changes if needed

### **3. Approval**
- Once approved, you can merge
- Click "Merge pull request"
- Delete the feature branch

### **4. Deployment**
- Changes are merged to main
- Deploy to production
- Monitor for issues

---

## 🔗 Direct Links

**Create PR Directly:**
```
https://github.com/digicoyotes-web/hexatp-1/compare/main...feature/database-consultation-system
```

**View All PRs:**
```
https://github.com/digicoyotes-web/hexatp-1/pulls
```

**View Commits:**
```
https://github.com/digicoyotes-web/hexatp-1/commits/feature/database-consultation-system
```

---

## 💡 Tips

1. **Clear Title**: Use descriptive titles that explain what the PR does
2. **Detailed Description**: Explain why the changes were made
3. **Link Issues**: Reference related issues with `Closes #123`
4. **Add Labels**: Help others find related PRs
5. **Request Reviewers**: Get feedback from team members
6. **Keep PRs Small**: Easier to review and merge
7. **Test Before PR**: Ensure all tests pass locally

---

## 🎯 PR Checklist

Before creating the PR, verify:

- ✅ All commits are pushed to GitHub
- ✅ Branch name is descriptive
- ✅ Code is tested locally
- ✅ Documentation is updated
- ✅ No merge conflicts
- ✅ All tests pass
- ✅ Code follows style guide

---

## 📞 Need Help?

If you encounter issues:

1. **Check GitHub Status**: https://www.githubstatus.com
2. **Review GitHub Docs**: https://docs.github.com/en/pull-requests
3. **Contact Support**: md@hexatp.com

---

## ✨ Summary

**Creating a Pull Request is Easy:**

1. Go to: https://github.com/digicoyotes-web/hexatp-1/pulls
2. Click: "New pull request"
3. Select: base = `main`, compare = `feature/database-consultation-system`
4. Fill: Title and description
5. Click: "Create pull request"
6. Done! ✅

---

**Status**: ✅ Ready to Create PR  
**Branch**: feature/database-consultation-system  
**Target**: main
