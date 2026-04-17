# GitHub to XAMPP Integration Guide

## 🔗 Connecting GitHub Repository to Local XAMPP

This guide explains how to sync your GitHub repository with your local XAMPP installation.

---

## 📍 Current Setup

- **GitHub Repository**: https://github.com/sakshidhawale5004/hexa-final
- **Local Path**: `C:\xampp3\htdocs\hexatp-main`
- **Database**: MySQL (hexatp_db)
- **Server**: Apache + PHP via XAMPP

---

## 🚀 Initial Setup (First Time)

### Step 1: Clone Repository to XAMPP

Open Git Bash or Command Prompt:

```bash
# Navigate to XAMPP htdocs
cd C:\xampp3\htdocs

# Clone the repository
git clone https://github.com/sakshidhawale5004/hexa-final.git hexatp-main

# Enter the directory
cd hexatp-main
```

### Step 2: Configure Git

```bash
# Set your Git username
git config user.name "Your Name"

# Set your Git email
git config user.email "your.email@example.com"
```

### Step 3: Verify Connection

```bash
# Check remote repository
git remote -v

# Should show:
# origin  https://github.com/sakshidhawale5004/hexa-final.git (fetch)
# origin  https://github.com/sakshidhawale5004/hexa-final.git (push)
```

---

## 🔄 Daily Workflow

### Pull Latest Changes from GitHub

Before starting work, always pull the latest changes:

```bash
cd C:\xampp3\htdocs\hexatp-main
git pull origin main
```

### Make Changes Locally

1. Edit files in `C:\xampp3\htdocs\hexatp-main`
2. Test on: `http://localhost/hexatp-main/`
3. Verify everything works

### Push Changes to GitHub

```bash
# Check what files changed
git status

# Add all changed files
git add .

# Or add specific files
git add index.html contact.html

# Commit with a message
git commit -m "Updated contact form and homepage"

# Push to GitHub
git push origin main
```

---

## 📝 Common Git Commands

### Check Status
```bash
git status
```

### View Changes
```bash
git diff
```

### View Commit History
```bash
git log --oneline
```

### Discard Local Changes
```bash
# Discard changes to a specific file
git checkout -- filename.html

# Discard all local changes
git reset --hard HEAD
```

### Create a New Branch
```bash
# Create and switch to new branch
git checkout -b feature-name

# Push new branch to GitHub
git push -u origin feature-name
```

### Switch Branches
```bash
# Switch to main branch
git checkout main

# Switch to another branch
git checkout feature-name
```

---

## 🔧 Handling Conflicts

If you get a merge conflict:

```bash
# Pull with rebase
git pull --rebase origin main

# Or pull and merge
git pull origin main

# If conflicts occur:
# 1. Open conflicted files
# 2. Resolve conflicts manually
# 3. Add resolved files
git add .

# 4. Continue
git rebase --continue
# or
git commit -m "Resolved conflicts"

# 5. Push
git push origin main
```

---

## 🗂️ Files to Exclude from Git

Already configured in `.gitignore`:

```
node_modules/          # Node packages (MongoDB removed)
.env                   # Environment variables
*.log                  # Log files
.DS_Store             # Mac OS files
Thumbs.db             # Windows files
.vscode/              # VS Code settings
```

### Important: Database Configuration

**DO NOT commit** sensitive database credentials to GitHub!

If you need different credentials for production:

1. Create `.env` file (already in .gitignore):
```env
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=hexatp_db
```

2. Update `db_config.php` to read from .env (optional)

---

## 🔐 Security Best Practices

### 1. Never Commit Sensitive Data
- Database passwords
- API keys
- Private keys
- User data

### 2. Use Environment Variables
Create `.env` file for sensitive data (already ignored by Git)

### 3. Review Before Pushing
```bash
# Always check what you're committing
git diff --staged
```

---

## 📊 Workflow Example

### Scenario: Update Homepage

```bash
# 1. Pull latest changes
cd C:\xampp3\htdocs\hexatp-main
git pull origin main

# 2. Make changes
# Edit index.html in your editor

# 3. Test locally
# Open http://localhost/hexatp-main/index.html

# 4. Check changes
git status
git diff index.html

# 5. Stage changes
git add index.html

# 6. Commit
git commit -m "Updated homepage hero section"

# 7. Push to GitHub
git push origin main
```

---

## 🌐 Deploying to Production

When ready to deploy to a live server:

### Option 1: Direct Git Clone on Server
```bash
# On your hosting server
git clone https://github.com/sakshidhawale5004/hexa-final.git
```

### Option 2: FTP Upload
1. Upload files from `C:\xampp3\htdocs\hexatp-main`
2. Exclude: `node_modules/`, `.git/`, `.env`

### Option 3: Hosting Platform Integration
- Connect GitHub to Hostinger/cPanel
- Enable auto-deployment on push

---

## 🔍 Troubleshooting

### Issue: "Permission denied (publickey)"
**Solution**: Set up SSH key or use HTTPS with personal access token

```bash
# Use HTTPS instead
git remote set-url origin https://github.com/sakshidhawale5004/hexa-final.git
```

### Issue: "Your branch is behind"
**Solution**: Pull changes first

```bash
git pull origin main
```

### Issue: "Failed to push"
**Solution**: Pull, resolve conflicts, then push

```bash
git pull origin main
# Resolve any conflicts
git push origin main
```

### Issue: "Changes not showing on GitHub"
**Solution**: Verify you pushed to correct branch

```bash
git branch  # Check current branch
git push origin main  # Push to main
```

---

## 📱 GitHub Desktop Alternative

If you prefer a GUI:

1. Download [GitHub Desktop](https://desktop.github.com/)
2. Clone repository: `https://github.com/sakshidhawale5004/hexa-final`
3. Set local path: `C:\xampp3\htdocs\hexatp-main`
4. Use GUI to commit and push changes

---

## ✅ Quick Reference

| Task | Command |
|------|---------|
| Clone repo | `git clone <url>` |
| Pull changes | `git pull origin main` |
| Check status | `git status` |
| Add files | `git add .` |
| Commit | `git commit -m "message"` |
| Push | `git push origin main` |
| View history | `git log` |
| Discard changes | `git checkout -- <file>` |

---

## 🎯 Summary

Your setup:
- ✅ GitHub repository connected
- ✅ Local XAMPP environment at `C:\xampp3\htdocs\hexatp-main`
- ✅ MySQL database configured
- ✅ MongoDB dependencies removed
- ✅ Ready for development and deployment

**Workflow**: Edit locally → Test on XAMPP → Commit → Push to GitHub → Deploy to production

---

## 📞 Need Help?

- [Git Documentation](https://git-scm.com/doc)
- [GitHub Guides](https://guides.github.com/)
- [XAMPP Documentation](https://www.apachefriends.org/docs/)

**Happy Coding! 🚀**
