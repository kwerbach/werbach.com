# Accessibility & Performance Testing Guide

This guide helps verify that the website meets WCAG 2.1 AA standards and maintains excellent Web Vitals scores, reflecting academic credibility.

## ✅ Completed Accessibility Features

### 1. Motion Preferences
- **prefers-reduced-motion support**: Binary animation pauses for users with motion sensitivity
- **Global animation disabling**: All animations respect user preferences via CSS media query
- **Implementation**: MediaQuery API in HeroBinary.tsx, global CSS in index.css

### 2. Keyboard Navigation
- **Skip-to-content link**: First tab stop allows jumping directly to main content
- **Focus indicators**: Blue ring (ring-2 ring-blue-600) on all interactive elements
- **Route prefetching**: Top 3 routes (/ideas, /projects, /podcast) prefetch on hover
- **Implementation**: App.tsx skip link, Nav.tsx focus styles, index.css focus-visible

### 3. ARIA Labels & Semantic HTML
- **Navigation**: `aria-label="Main navigation"` on nav element
- **Card links**: `aria-label="Read more about {title}"` on all card links
- **Tags**: `role="list"` and `role="listitem"` for tag lists
- **Time elements**: Proper `<time dateTime>` for dates
- **Implementation**: Nav.tsx, Card.tsx with semantic HTML

### 4. Lazy Loading & Performance
- **LazyImage component**: Native lazy loading with aspect ratio preservation
- **LazyIframe component**: Intersection Observer for embedded content
- **Loading skeletons**: Animated gradient placeholders during load
- **Responsive images**: srcSet support for optimal image sizes
- **Implementation**: LazyImage.tsx, LazyIframe.tsx, index.css animations

### 5. Touch Target Sizes
- **Minimum 44x44px**: All buttons and links meet mobile touch target requirements
- **Implementation**: index.css media query for pointer: coarse

### 6. High Contrast Mode
- **Border visibility**: currentColor borders for high contrast
- **Link underlines**: Automatic underlining in high contrast mode
- **Implementation**: index.css @media (prefers-contrast: high)

### 7. Print Styles
- **Academic credibility**: Clean print layout with URLs after links
- **Hidden chrome**: Navigation and footer hidden when printing
- **Page breaks**: Proper page-break-inside handling for articles
- **Implementation**: index.css @media print

## 🧪 Manual Testing Checklist

### Keyboard Navigation Test

1. **Open homepage**: https://localhost:5173
2. **Press Tab**: Should highlight skip-to-content link (blue ring)
3. **Press Enter**: Should jump to main content area
4. **Continue tabbing**: Should see blue focus ring on all links/buttons
5. **Verify tab order**: Navigation → content cards → footer links
6. **Press Shift+Tab**: Should reverse tab order correctly

✅ **Success criteria**: 
- All interactive elements reachable by keyboard
- Focus indicators visible at all times
- Skip link functional
- Logical tab order maintained

### Screen Reader Test (macOS VoiceOver)

1. **Enable VoiceOver**: Cmd + F5
2. **Navigate with VO keys**: Control + Option + Arrow keys
3. **Verify announcements**:
   - "Main navigation, navigation"
   - "Skip to main content, link"
   - Card titles and descriptions read correctly
   - "Read more about [title], link"
   - Tag lists announced as lists
4. **Test landmarks**: Should announce main, nav, footer regions

✅ **Success criteria**:
- All content accessible via screen reader
- Links have descriptive text
- Lists and landmarks properly announced
- No empty or redundant announcements

### Motion Preferences Test

1. **Open System Preferences** → Accessibility → Display
2. **Enable "Reduce motion"**
3. **Reload website**: Binary animation should pause
4. **Check transitions**: Should be instant (0.01ms)
5. **Disable "Reduce motion"**
6. **Reload website**: Animations should resume

✅ **Success criteria**:
- Binary animation completely pauses with reduce motion enabled
- Card hover animations disabled
- Loading skeletons static
- All transitions instant

### Touch Target Test (Mobile)

1. **Open in mobile browser** or use Chrome DevTools mobile emulation
2. **Try tapping links**: Should be easy to tap without mis-taps
3. **Test navigation**: All nav items should be tappable
4. **Test cards**: Full card should be clickable

✅ **Success criteria**:
- All touch targets minimum 44x44px
- No accidental taps on adjacent elements
- Easy one-handed navigation

## 📊 Performance Testing (Web Vitals)

### Chrome DevTools Performance Test

1. **Open Chrome DevTools**: F12
2. **Go to Lighthouse tab**
3. **Run audit**: Desktop, Performance + Accessibility
4. **Check scores**:
   - Performance: Should be 90+
   - Accessibility: Should be 95+ (aim for 100)
   - Best Practices: Should be 95+
   - SEO: Should be 100

### Specific Web Vitals

#### CLS (Cumulative Layout Shift) - Target: < 0.1

1. **Open DevTools** → Performance tab
2. **Record page load**
3. **Check Experience section** → Layout Shifts
4. **Verify score**: Should be < 0.1 (green)

**CLS Prevention Measures**:
- Aspect ratio containers on LazyImage (prevents image-caused shifts)
- Aspect ratio containers on LazyIframe (prevents embed-caused shifts)
- Fixed dimensions on all images
- Font-display: swap in CSS
- No ads or dynamic content injection

#### LCP (Largest Contentful Paint) - Target: < 2.5s

1. **Open DevTools** → Performance tab
2. **Record page load**
3. **Check Timings section** → LCP
4. **Verify score**: Should be < 2.5s

**LCP Optimization**:
- Route prefetching for fast navigation
- Lazy loading for below-fold content
- Optimized bundle size with code splitting

#### FID (First Input Delay) - Target: < 100ms

1. **Test interaction**: Click navigation link within first 1-2 seconds
2. **Should respond instantly**
3. **Check Console**: No blocking scripts

**FID Optimization**:
- React lazy loading for route components
- Non-blocking CSS
- Deferred non-critical scripts

### Real User Monitoring

Use Chrome User Experience Report (CrUX) data after deployment:
```bash
# Install web-vitals library
npm install web-vitals

# Add to your app (already in main.tsx):
import { onCLS, onFID, onLCP } from 'web-vitals';

onCLS(console.log);
onFID(console.log);
onLCP(console.log);
```

## 🔧 Testing Tools

### Automated Testing

```bash
# Install axe-core for automated accessibility testing
npm install --save-dev @axe-core/cli

# Run accessibility audit
npx axe https://localhost:5173 --exit
```

### Browser Extensions

- **axe DevTools**: Chrome/Firefox extension for WCAG compliance
- **WAVE**: Web accessibility evaluation tool
- **Lighthouse**: Built into Chrome DevTools
- **Web Vitals**: Chrome extension for real-time metrics

### Screen Readers

- **macOS**: VoiceOver (Cmd + F5)
- **Windows**: NVDA (free) or JAWS
- **iOS**: VoiceOver (Settings → Accessibility)
- **Android**: TalkBack (Settings → Accessibility)

## 📝 Testing Results Template

```markdown
## Accessibility Audit Results

Date: [DATE]
Tester: [NAME]

### Keyboard Navigation
- [ ] Skip link works
- [ ] All elements focusable
- [ ] Focus indicators visible
- [ ] Logical tab order

### Screen Reader
- [ ] Content announced correctly
- [ ] Links descriptive
- [ ] Landmarks identified
- [ ] No empty announcements

### Motion Preferences
- [ ] Animations pause when reduced motion enabled
- [ ] Transitions instant
- [ ] No dizziness or discomfort

### Web Vitals
- CLS: [SCORE] (target: < 0.1)
- LCP: [SCORE]s (target: < 2.5s)
- FID: [SCORE]ms (target: < 100ms)

### Lighthouse Scores
- Performance: [SCORE]/100
- Accessibility: [SCORE]/100
- Best Practices: [SCORE]/100
- SEO: [SCORE]/100

### Issues Found
1. [ISSUE DESCRIPTION]
   - Severity: [LOW/MEDIUM/HIGH]
   - WCAG Criterion: [X.X.X]
   - Fix: [DESCRIPTION]

### Recommendations
- [RECOMMENDATION 1]
- [RECOMMENDATION 2]
```

## 🎯 WCAG 2.1 AA Compliance Checklist

### Perceivable
- [x] 1.1.1 Non-text Content (Alt text)
- [x] 1.3.1 Info and Relationships (Semantic HTML)
- [x] 1.3.2 Meaningful Sequence (Tab order)
- [x] 1.4.3 Contrast (Minimum)
- [x] 1.4.10 Reflow (Responsive design)
- [x] 1.4.12 Text Spacing (No fixed line heights)

### Operable
- [x] 2.1.1 Keyboard (All functionality)
- [x] 2.1.2 No Keyboard Trap
- [x] 2.2.2 Pause, Stop, Hide (Motion controls)
- [x] 2.4.1 Bypass Blocks (Skip link)
- [x] 2.4.3 Focus Order (Logical)
- [x] 2.4.7 Focus Visible (Indicators)
- [x] 2.5.5 Target Size (44x44px minimum)

### Understandable
- [x] 3.1.1 Language of Page (HTML lang attribute)
- [x] 3.2.3 Consistent Navigation
- [x] 3.2.4 Consistent Identification

### Robust
- [x] 4.1.2 Name, Role, Value (ARIA labels)
- [x] 4.1.3 Status Messages (Live regions if needed)

## 🚀 Pre-Deployment Checklist

Before deploying to production:

1. [ ] Run Lighthouse audit (all scores 90+)
2. [ ] Test keyboard navigation completely
3. [ ] Test with VoiceOver/screen reader
4. [ ] Verify CLS < 0.1 on all pages
5. [ ] Test with prefers-reduced-motion enabled
6. [ ] Test on mobile device (touch targets)
7. [ ] Test in high contrast mode
8. [ ] Print test (academic use case)
9. [ ] Run automated accessibility tests (axe)
10. [ ] Verify all images have alt text
11. [ ] Check all links have descriptive text
12. [ ] Verify form labels (if any forms added)

## 📚 Resources

- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [Web Vitals Documentation](https://web.dev/vitals/)
- [MDN Accessibility Guide](https://developer.mozilla.org/en-US/docs/Web/Accessibility)
- [a11y Project Checklist](https://www.a11yproject.com/checklist/)
- [WebAIM Screen Reader Testing](https://webaim.org/articles/screenreader_testing/)
