# Sitegeist.ChitChat
## Deterministic randomized text generator for styleguide props 

Presentational components for the monocle styleguide tend to have longish @styleguide.props that are hard to maintain, 
tend to overshadow the actual component and often do not provide enough diversion to actually test different text lengths.

ChitChat generates pseudo random texts that can be used in styleguide props. The texts are generated uniquely for each
insertion point (fusion path) using pseudo random numbers.

The styleguide only specifies that a headline follows by two paragraphs and a list is needed. **No need to copy and paste the 
same lorem ipsum texts over and over again!**

```neosfusion
dummytext = afx`
  <Sitegeist.ChitChat:H2 italic />
  <Sitegeist.ChitChat:H3 />
  <Sitegeist.ChitChat:P links bold />
  <Sitegeist.ChitChat:P length={500} />
  <Sitegeist.ChitChat:OL links />
`
```

The implementation was inspired by the js library getlorem https://github.com/lukehaas/getlorem/. 
Also the word list we use started as a copy from getlorem.

### Authors & Sponsors

* Melanie Wüst - wuest@sitegeist.de
* Martin Ficzel - ficzel@sitegeist.de

*The development and the public-releases of this package is generously sponsored
by our employer http://www.sitegeist.de.*

## Installation

Sitegeist.ChitChat is available via packagist and can be installed with the command `composer require sitegeist/chitchat`.

We use semantic-versioning so every breaking change will increase the major-version number.

## Usage

```neosfusion
prototype(Vendor.Site:ChitChat) < prototype(Neos.Fusion:Component) {
    @styleguide {
        title = "ChitChat"
        props.text = afx`
            <Sitegeist.ChitChat:H1 italic />
            <Sitegeist.ChitChat:H2 length={120} />
            <Sitegeist.ChitChat:P links italic bold />
            <Sitegeist.ChitChat:P links italic bold />
            <Sitegeist.ChitChat:P />
            <Sitegeist.ChitChat:H3 />
            <Sitegeist.ChitChat:UL links />
            <Sitegeist.ChitChat:H3 />
            <Sitegeist.ChitChat:OL links />
        `
    }

    text = null

    renderer = afx`
        <div>{props.text}</div>
    `
}
```

### Fusion Prototypes

- `Sitegeist.ChitChat:H1`:  (string) A sentence in a h1-tag
- `Sitegeist.ChitChat:H2`:  (string) A sentence in a h2-tag
- `Sitegeist.ChitChat:H3`:  (string) A sentence in a h3-tag
- `Sitegeist.ChitChat:H4`:  (string) A sentence in a h4-tag
- `Sitegeist.ChitChat:P`:  (string) A sentence in a p-tag
- `Sitegeist.ChitChat:UL`:  (string) Multiple sentences as unordered list.
- `Sitegeist.ChitChat:OL`:  (string) Multiple sentences as ordered list.

The prototypes have the following properties, all are optional:

- `seed` (string|null) the source of randomness in addition to the fusion path
- `length` (int) the length the text should approximately have
- `deviation` (int) the deviation on length to be used between consecutive items

- `link` (bool) add links to some items (`<a hraf="#">...</s>`)
- `bold` (bool) make some items bold (`<strong>...</strong>`)
- `italic` (bool) make some items italic (`<i>...</i>`)

### Base Prototypes 

The following Prototypes generate texts of one or multiple sentences. 
- `Sitegeist.ChitChat:Paragraph`:  (string) textblock containing multiple sentences
- `Sitegeist.ChitChat:Sentence `:  (string) sentence containing multiple words

The following prototypes generate arrays of strings and are handy to create  
lists and menu dummys.
- `Sitegeist.ChitChat:Sentences`:  (array) multiple sentences
- `Sitegeist.ChitChat:Words`:  (array) multiple words

The common properties are supported here aswell.

 
## Contribution

We will gladly accept contributions. Please send us pull requests.
