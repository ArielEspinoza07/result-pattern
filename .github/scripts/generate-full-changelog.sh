#!/bin/bash
set -e

# Inicializar contenido
FULL_CHANGELOG="# Changelog\n\n"

# Obtener todos los tags en orden
TAGS=($(git tag --sort=creatordate))

# Si no hay tags, terminar
if [ ${#TAGS[@]} -eq 0 ]; then
  echo "No tags found. Exiting."
  exit 0
fi

# Agregar un pseudo-tag inicial para el primer commit
PREVIOUS=""
for CURRENT in "${TAGS[@]}"; do
  DATE=$(git log -1 --format=%ad --date=short "$CURRENT")
  FULL_CHANGELOG+="## $CURRENT - $DATE\n"

  # Definir el rango de commits
  RANGE="${PREVIOUS:+$PREVIOUS..}$CURRENT"

  # Inicializar secciones
  ADDED="" FIXED="" CHANGED="" DOCS="" OTHER=""

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

  [ -n "$ADDED" ] && FULL_CHANGELOG+="\n### Added\n$ADDED"
  [ -n "$FIXED" ] && FULL_CHANGELOG+="\n### Fixed\n$FIXED"
  [ -n "$CHANGED" ] && FULL_CHANGELOG+="\n### Changed\n$CHANGED"
  [ -n "$DOCS" ] && FULL_CHANGELOG+="\n### Docs\n$DOCS"
  [ -n "$OTHER" ] && FULL_CHANGELOG+="\n### Other\n$OTHER"
  FULL_CHANGELOG+="\n"

  PREVIOUS="$CURRENT"
done

# Guardar en CHANGELOG.md
echo -e "$FULL_CHANGELOG" > CHANGELOG.md
