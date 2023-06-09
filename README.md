# Sitegeist.ChitChat
## Deterministic randomized text generator for styleguide props 

Presentational components for the monocle styleguide tend to have longish @styleguide.props that are hard to maintain, 
tend to overshadow the actual component and often do not provide enough diversion to actually test different text lengths.

ChitChat generates pseudo random texts that can be used in styleguide props. The texts are generated uniquely for each
insertion point (fusion path) using pseudo random numbers.

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

The `Line` and `Text` prototypes generate a pseudo random text. 
The text is much longer and structured as multiple sentences. 
Both prototypes allow to enable formatting via `links`, `strong` and `em`. 

```neosfusion
prototype(Sitegeist.ChitChat:CardExample) < prototype(Neos.Fusion:Component) {
    @styleguide {
        title = "ChitChat CardExample"
      
        props {
            # a short text without formatting
            title = Sitegeist.ChitChat:Line
            # a textblock with multiple sentences and some formatting
            description = Sitegeist.ChitChat:Text {
                length = 250
                link = true
                strong = true
                em = true
            }
        }
    }

    title = null
    description = null

    renderer = afx`
        <div>
            <h3>{props.title}</p>
            <p>{props.description}</p>
        </div>
    `
}
```

For simulating longer and formatted texts chitchat brings prototypes to simulate
Html Headings, Paragraphs and Lists. Those allow to specify the expected structure 
of the `content` prop. Together with the afx syntax this allows to efficiently mock 
larger texts.

```neosfusion
prototype(Sitegeist.ChitChat:TextExample) < prototype(Neos.Fusion:Component) {
    @styleguide {
        title = "ChitChat TextExample"
      
        props {
            # a block with mutltiple headlines paragraphs and lists
            content = afx`
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
    }

    content = null

    renderer = afx`
        <div>{props.content}</div>
    `
}
```

### Base Prototypes

The base prototypes `Text` and `Line` will create text without block formatting.   

- `Sitegeist.ChitChat:Text`:  (string) long textblock containing multiple sentences
- `Sitegeist.ChitChat:Line`:  (string) short textblock without

Properties:

- `dictionary` (string|`default`) the name of the dictionaries as configured in the settings
- `seed` (string|null) the source of randomness in addition to the fusion path
- `length` (int|100 bzw. 500) the maximal length the text should have
- `variance` (float|0.5) the deviation in length that is allowed 
- `link` (bool|false) add links to some items `<a href="#">...</s>`
- `strong` (bool|false) make some items bold `<strong>...</strong>`
- `em` (bool|false) emphasize some items `<em>...</em>`

### Textblock Fusion Prototypes

The textblocks extend the base prototypes with block formatting.
Otherwise they support the same properties as `Text` and `Line`. 

- `Sitegeist.ChitChat:H1`:  (string) A sentence in a h1-tag
- `Sitegeist.ChitChat:H2`:  (string) A sentence in a h2-tag
- `Sitegeist.ChitChat:H3`:  (string) A sentence in a h3-tag
- `Sitegeist.ChitChat:H4`:  (string) A sentence in a h4-tag
- `Sitegeist.ChitChat:P`:  (string) A sentence in a p-tag with links, strong and em

### List Fusion Prototypes

The list prototypes extend the base prototypes with list formatting.
The prototypes have the properties as the base prototypes, in addition the
property `number` allows to specify how many items are to be generated. 

- `Sitegeist.ChitChat:UL`:  (string) Multiple sentences as unordered list with links, strong and em
- `Sitegeist.ChitChat:OL`:  (string) Multiple sentences as ordered list with links, strong and em

Additional properties:

- `number` (int|5) the number of items to generate

## Replacing the dictionary or "how to speak klingon"

To implement custom dictionaries you can provide alternate implementations of the
interface `\Sitegeist\ChitChat\Domain\DictionaryProviderInterface`. 
 
The dictionaries are registered via Setting.yaml:

```yaml
Sitegeist:
  ChitChat:
    dictionaries:
      klingon: 'Vendor\Example\KlingonDictionaryProvider'
```

And can later be used like this:

```neosfusion
text = Sitegeist.ChitChat:Text {
  dictionary = 'klingon'
} 
```

## Contribution

We will gladly accept contributions. Please send us pull requests.
