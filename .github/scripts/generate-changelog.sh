#!/bin/bash

set -e

# Variables
NEW_VERSION=$1

if [ -z "$NEW_VERSION" ]; then
  echo "❌ Error: Provide the new version tag (e.g. v1.2.3)"
  exit 1
fi

# Detect last git tag
LAST_TAG=$(git describe --tags --abbrev=0 2>/dev/null || echo "")

# Determine git range
if [ -z "$LAST_TAG" ]; then
  GIT_RANGE=""
else
  GIT_RANGE="$LAST_TAG..HEAD"
fi

# Get today's date
TODAY=$(date +%F)
CHANGELOG="## $NEW_VERSION - $TODAY\n"

# Sections
ADDED=""
FIXED=""
CHANGED=""
DOCS=""
OTHER=""

# Extract commit messages and classify
while IFS= read -r COMMIT; do
  TYPE=$(echo "$COMMIT" | sed -nE 's/^([a-z]+)\(.+\):.*/\1/p')
  SCOPE=$(echo "$COMMIT" | sed -nE 's/^[a-z]+\((.+)\):.*/\1/p')
  MESSAGE=$(echo "$COMMIT" | sed -nE 's/^[a-z]+\(.+\):\s*(.*)/\1/p')

  case "$TYPE" in
    feat) ADDED+="- $MESSAGE\n" ;;
    fix) FIXED+="- $MESSAGE\n" ;;
    refactor|perf|style|chore) CHANGED+="- $MESSAGE\n" ;;
    docs) DOCS+="- $MESSAGE\n" ;;
    *)
      OTHER+="- $COMMIT\n"
      ;;
  esac
done < <(git log $GIT_RANGE --pretty=format:"%s" --no-merges)

# Append sections to changelog if not empty
[ -n "$ADDED" ] && CHANGELOG+="\n### Added\n$ADDED"
[ -n "$FIXED" ] && CHANGELOG+="\n### Fixed\n$FIXED"
[ -n "$CHANGED" ] && CHANGELOG+="\n### Changed\n$CHANGED"
[ -n "$DOCS" ] && CHANGELOG+="\n### Docs\n$DOCS"
[ -n "$OTHER" ] && CHANGELOG+="\n### Other\n$OTHER"

[ -z "$ADDED$FIXED$CHANGED$DOCS$OTHER" ] && CHANGELOG+="\n_No changes since last release._\n"

# Insert at top of CHANGELOG.md
if [ -f CHANGELOG.md ]; then
  echo -e "$CHANGELOG\n$(cat CHANGELOG.md)" > CHANGELOG.md
else
  echo -e "# Changelog\n\n$CHANGELOG" > CHANGELOG.md
fi

# Commit
 git config user.name "github-actions"
 git config user.email "github-actions@github.com"
 git add CHANGELOG.md
 git commit -m "docs(changelog): update changelog for $NEW_VERSION" || echo "⚠️ No changes to commit"
