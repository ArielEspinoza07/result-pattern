#!/bin/bash

set -e

# Get all tags sorted by date (newest to oldest)
TAGS=($(git tag --sort=-creatordate))

# Initialize final changelog
FINAL_CHANGELOG="# Changelog\n"

for ((i = 0; i < ${#TAGS[@]}; i++)); do
  TAG=${TAGS[$i]}
  PREV_TAG=${TAGS[$((i + 1))]}

  # Determine git range
  if [ -z "$PREV_TAG" ]; then
    RANGE="$TAG"
  else
    RANGE="$PREV_TAG..$TAG"
  fi

  # Get date from tag (fallback to today)
  TAG_DATE=$(git log -1 --format=%ad --date=short "$TAG" 2>/dev/null || date +%F)

  # Start section
  CHANGELOG="## $TAG - $TAG_DATE\n"

  # Reset sections
  ADDED=""; FIXED=""; CHANGED=""; DOCS=""; OTHER=""

  while IFS= read -r COMMIT; do
    TYPE=$(echo "$COMMIT" | sed -nE 's/^([a-z]+)\(.+\):.*/\1/p')
    MESSAGE=$(echo "$COMMIT" | sed -nE 's/^[a-z]+\(.+\):\s*(.*)/\1/p')

    case "$TYPE" in
      feat) ADDED+="- $MESSAGE\n" ;;
      fix) FIXED+="- $MESSAGE\n" ;;
      refactor|perf|style|chore) CHANGED+="- $MESSAGE\n" ;;
      docs) DOCS+="- $MESSAGE\n" ;;
      *) OTHER+="- $COMMIT\n" ;;
    esac
  done < <(git log $RANGE --pretty=format:"%s" --no-merges)

  # Append sections
  [ -n "$ADDED" ]   && CHANGELOG+="\n### Added\n$ADDED"
  [ -n "$FIXED" ]   && CHANGELOG+="\n### Fixed\n$FIXED"
  [ -n "$CHANGED" ] && CHANGELOG+="\n### Changed\n$CHANGED"
  [ -n "$DOCS" ]    && CHANGELOG+="\n### Docs\n$DOCS"
  [ -n "$OTHER" ]   && CHANGELOG+="\n### Other\n$OTHER"
  [ -z "$ADDED$FIXED$CHANGED$DOCS$OTHER" ] && CHANGELOG+="\n_No changes found._"

  FINAL_CHANGELOG+="$CHANGELOG\n\n"
done

# Write to file
echo -e "$FINAL_CHANGELOG" > CHANGELOG.md
