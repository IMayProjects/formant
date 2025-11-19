# Formant

Formant is an advanced tool for web-based survey construction & management tool

## Key features

1. Smart Question Graph
  -  Answer
    - Toggle Multiple response (eg: `+ add another`) 
    - INDEX 
  -  Question  
    -   NID (Node ID)
      -  `node(nid)` points to a particular node & grants access to its properties
      -  `question(nid)`, `section(nid)`, `answer(INDEX)` (matches exact answer) or `answer()` (matches any of the answers) which grant access to nodes as specific types of objects with their properties.
    - require(\[(expression1),expression2,...\]) / require(null)
    -  Question Toggling
      -  Progress to...
      -  Display if....
  - Response validation
    - Based on current question
    - Based on another question
  - Section Navigation
    - NID
    - require(nid,\[expression1,expression2,...\])
2. Survey Declaration DSL (QuestScript)
  - Logical Typing System
    - Bool < Whole Number (or basic Whole Expression) < Decimal Number (or basic Decimal Expression) < Text
    - expression evaluation
    - no function execution, just question declaration.
    - input cleansing rules.
      - trim whitespace,
      - Capitalise Rule \[UPPER, lower, Name, Title of Thing\],
      - delete leading 'x',
      - replace 'whitespace'
  - Survey gets served based on evaluation of QuestScript declaration.
3. Rich Exports
  -  Responses CSV
  -  Document Templating Editor
4. Robust Collaborative Responses
  -  save response draft in user library
  -  share response draft with other respondents

