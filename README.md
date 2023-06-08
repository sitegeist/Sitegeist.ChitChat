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
  <Sitegeist.ChitChat:H2 />
  <Sitegeist.ChitChat:H3 />
  <Sitegeist.ChitChat:P />
  <Sitegeist.ChitChat:P />
  <Sitegeist.ChitChat:OL />
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
            <Sitegeist.ChitChat:H1 />
            <Sitegeist.ChitChat:H2 />
            <Sitegeist.ChitChat:P />
            <Sitegeist.ChitChat:P />
            <Sitegeist.ChitChat:P />
            <Sitegeist.ChitChat:H3 />
            <Sitegeist.ChitChat:UL />
            <Sitegeist.ChitChat:H3 />
            <Sitegeist.ChitChat:OL />
        `
    }

    text = null

    renderer = afx`
        <div>{props.text}</div>
    `
}
```

### Text Fusion Prototypes

- `Sitegeist.ChitChat:H1`:  (string) A sentence in a h1-tag
- `Sitegeist.ChitChat:H2`:  (string) A sentence in a h2-tag
- `Sitegeist.ChitChat:H3`:  (string) A sentence in a h3-tag
- `Sitegeist.ChitChat:H4`:  (string) A sentence in a h4-tag
- `Sitegeist.ChitChat:P`:  (string) A sentence in a p-tag

The prototypes have the following properties, all are optional:

- `seed` (string|null) the source of randomness in addition to the fusion path
- `minLength` (int) the minimal length the text should have
- `maxLength` (int) the maximal length the text should have

### List Fusion Prototypes
 
- `Sitegeist.ChitChat:UL`:  (string) Multiple sentences as unordered list.
- `Sitegeist.ChitChat:OL`:  (string) Multiple sentences as ordered list.

The prototypes have the following properties, all are optional:

- `length` (int|5) the number of items
- `itemMinLength` (int) the minimal length a list item should have
- `itemMaxLength` (int) the maximal length a list item should have
- 
### Base Prototypes 

- `Sitegeist.ChitChat:Text`:  (string) textblock containing multiple sentences

Properties:

- `seed` (string|null) the source of randomness in addition to the fusion path
- `minLength` (int) the minimal length the text should have
- `maxLength` (int) the maximal length the text should have

## Contribution

We will gladly accept contributions. Please send us pull requests.
