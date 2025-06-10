#!/bin/bash

echo "# Changelog" > CHANGELOG.md
echo "" >> CHANGELOG.md

# Lista de fechas de commits (únicas y ordenadas)
dates=$(git log --pretty="%ad" --date=short | sort -u | tac)

for date in $dates; do
  echo "## $date" >> CHANGELOG.md
  echo "" >> CHANGELOG.md

  git log --since="$date 00:00:00" --until="$date 23:59:59" --pretty="* %s" >> CHANGELOG.md
  echo "" >> CHANGELOG.md
done
