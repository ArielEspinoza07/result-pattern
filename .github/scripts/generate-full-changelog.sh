#!/bin/bash

set -e

# Get all tags sorted by version (oldest to newest)
TAGS=($(git tag --sort=creatordate))

# Get today's date
TODAY=$(date +%F)

# Initialize final changelog
FINAL_CHANGELOG="# Changelog\n"

for ((i = 0; i < ${#TAGS[@]}; i++)); do
  TAG=${TAGS[$i]}
  NEXT_TAG=${TAGS[$((i + 1))]}

  # Determine range: last tag to current
  if [ "$i" -eq 0 ]; then
    RANGE=$(git rev-list --max-parents=0 HEAD)..$TAG
  else
    RANGE="${TAGS[$((i-1))]}..$TAG"
  fi

  # Start section
  CHANGELOG="## $TAG - $TODAY\n"

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
  [ -n "$ADDED" ] && CHANGELOG+="\n### Added\n$ADDED"
  [ -n "$FIXED" ] && CHANGELOG+="\n### Fixed\n$FIXED"
  [ -n "$CHANGED" ] && CHANGELOG+="\n### Changed\n$CHANGED"
  [ -n "$DOCS" ] && CHANGELOG+="\n### Docs\n$DOCS"
  [ -n "$OTHER" ] && CHANGELOG+="\n### Other\n$OTHER"
  [ -z "$ADDED$FIXED$CHANGED$DOCS$OTHER" ] && CHANGELOG+="\n_No changes found._"

  FINAL_CHANGELOG+="$CHANGELOG\n\n"
done

# Write final changelog
echo -e "$FINAL_CHANGELOG" > CHANGELOG.md
