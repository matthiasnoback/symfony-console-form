#!/usr/bin/env bash

ROOT="$PWD"

if [ ! -d git-hooks ]; then
    echo "Run this script from the root directory of the project" >&2
fi

ln -s "$ROOT/git-hooks/pre-commit" "$ROOT/.git/hooks/pre-commit"
