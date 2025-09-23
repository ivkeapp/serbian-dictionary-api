# Serbian Text Converter

A live, interactive web interface for converting Serbian text between Latin and Cyrillic scripts.

## Features

### **Bidirectional Conversion**
- **Latin to Cyrillic**: Convert Serbian Latin text to Cyrillic script
- **Cyrillic to Latin**: Convert Serbian Cyrillic text to Latin script  
- **Auto-detection**: Automatically detect the input script and convert to the opposite

### **Live Translation**
- Real-time conversion as you type (with 300ms debouncing)
- No page refresh needed
- Instant feedback and results

### **Advanced Script Handling**
- Proper handling of Serbian digraphs: `dž ↔ џ`, `lj ↔ љ`, `nj ↔ њ`
- Preserves case (uppercase/lowercase)
- Maintains punctuation and spacing
- Supports special Serbian characters: `č, ć, đ, š, ž`

### **Responsive Design**
- Works on desktop, tablet, and mobile devices
- Touch-friendly interface
- Adaptive layout that stacks on smaller screens

### **User-Friendly Features**
- **Copy to Clipboard**: One-click copying of results
- **Text Swap**: Exchange input and output text
- **Clear All**: Quick reset functionality
- **Character Counter**: Real-time character count for both input and output
- **Quick Examples**: Click examples to test functionality
- **Keyboard Shortcuts**: 
  - `Ctrl+Enter`: Manual transliteration
  - `Ctrl+C` (on output): Copy to clipboard
  - `Ctrl+L`: Clear all text

## Usage

### Web Interface

1. **Navigate to the converter**: Visit `/converter` on your API domain
2. **Choose conversion direction**:
   - **Auto Detect**: Automatically detects and converts (recommended)
   - **Latin → Cyrillic**: Forces Latin to Cyrillic conversion
   - **Cyrillic → Latin**: Forces Cyrillic to Latin conversion
3. **Type or paste text** in the input area
4. **View results** in real-time in the output area
5. **Copy results** by clicking the output area or using the copy button

### API Endpoint

You can also use the converter programmatically via the API endpoint:

**Endpoint**: `POST /converter/translate`

**Request Body**:
```json
{
    "text": "Your text here",
    "direction": "auto|latin-to-cyrillic|cyrillic-to-latin"
}
```

**Response**:
```json
{
    "success": true,
    "data": {
        "original": "Zdravo",
        "transliterated": "Здраво", 
        "direction": "auto",
        "detected_script": "latin"
    }
}
```

## Examples

### Basic Conversion
- **Input**: `Zdravo, kako ste?`
- **Output**: `Здраво, како сте?`

### Name Conversion  
- **Input**: `Miloš Petrović`
- **Output**: `Милош Петровић`

### Digraph Handling
- **Input**: `ljubav, njena, džungla`
- **Output**: `љубав, њена, џунгла`

### Mixed Content
- **Input**: `Beograd je glavni grad Srbije`
- **Output**: `Београд је главни град Србије`

## Technical Implementation

### Frontend
- **Pure JavaScript**: No external dependencies for core functionality
- **CSS Grid & Flexbox**: Modern responsive layout
- **AJAX**: Asynchronous API calls with error handling
- **Debouncing**: Optimized to prevent excessive API calls
- **Progressive Enhancement**: Works even if JavaScript fails

### Backend
- **CodeIgniter 4**: PHP framework
- **Transliteration Library**: Robust Serbian script conversion
- **JSON API**: RESTful endpoint for programmatic access
- **Error Handling**: Comprehensive error responses

### Character Mapping
The converter uses comprehensive character mapping tables including:

**Latin to Cyrillic**:
```
a→а, b→б, c→ц, d→д, e→е, f→ф, g→г, h→х, i→и, j→ј, k→к, l→л,
m→м, n→н, o→о, p→п, r→р, s→с, t→т, u→у, v→в, z→з
č→ч, ć→ћ, đ→ђ, š→ш, ž→ж
dž→џ, lj→љ, nj→њ
```

**Special Cases**:
- `q→к, w→в, x→кс, y→и` (for foreign words)
- Proper case preservation for all characters
- Support for both `DŽ` and `Dž` variants

## Browser Support

- **Modern Browsers**: Chrome 60+, Firefox 55+, Safari 11+, Edge 79+
- **Mobile**: iOS Safari 11+, Chrome Mobile 60+
- **Features**: 
  - Clipboard API (with fallback for older browsers)
  - CSS Grid (with Flexbox fallback)
  - ES6 Classes and async/await

## File Structure

```
/converter                          # Main converter page
/converter/translate               # API endpoint
/public/js/converter.js           # JavaScript functionality  
/public/css/converter.css         # Converter-specific styles
/app/Controllers/Converter.php    # Controller logic
/app/Views/converter.php          # Main view template
/app/Helpers/transliterator_helper.php  # Helper functions
/app/Libraries/Transliteration.php      # Core transliteration logic
```

## Integration

### As a Standalone Component
The converter can be embedded in other applications by:
1. Including the CSS and JavaScript files
2. Setting up the HTML structure
3. Configuring the API endpoint URL

### API Integration
Use the `/converter/translate` endpoint in your applications:

```javascript
// JavaScript example
async function translateText(text, direction = 'auto') {
    const response = await fetch('/converter/translate', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ text, direction })
    });
    return await response.json();
}
```

```php
// PHP example
$response = file_get_contents('http://your-api.com/converter/translate', false, 
    stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode(['text' => $text, 'direction' => 'auto'])
        ]
    ])
);
$result = json_decode($response, true);
```

## Performance

- **Debounced Input**: 300ms delay prevents excessive API calls
- **Lightweight**: Minimal JavaScript footprint
- **Caching**: Browser caches static assets
- **Optimized Rendering**: Efficient DOM updates

## Accessibility

- **Keyboard Navigation**: Full keyboard support
- **Screen Readers**: Proper ARIA labels and semantic HTML
- **High Contrast**: Supports system dark mode
- **Focus Indicators**: Clear visual focus states
- **Reduced Motion**: Respects user motion preferences

## Security

- **Input Validation**: Server-side validation of all inputs
- **XSS Prevention**: Proper output escaping
- **CSRF Protection**: CodeIgniter's built-in CSRF protection
- **Rate Limiting**: Can be configured at server level

## Future Enhancements

- **Batch Processing**: Multiple text conversion
- **File Upload**: Convert entire documents
- **History**: Save and recall previous conversions
- **Export Options**: Download results as TXT/PDF
- **Spell Check**: Integration with Serbian spell checker
- **Voice Input**: Speech-to-text functionality
- **Transliteration Rules**: Customizable conversion rules

## License

This converter is part of the Serbian Dictionary API project and follows the same licensing terms.