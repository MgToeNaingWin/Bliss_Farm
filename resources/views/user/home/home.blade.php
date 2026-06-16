@extends('user.layouts.master')
@section('content')


    <header class="hero">
        <h1>Empowering Farms With Proven Knowledge</h1>
        <p>Access peer-reviewed livestock management insights, structural farming guides, and sustainable biosecurity practices.</p>
        <div class="search-bar">
            <input type="text" placeholder="Search guides (e.g., Cattle nutrition, poultry diseases)...">
            <button type="button">Search</button>
        </div>
    </header>

    <div class="container">

        <section id="hub" class="section-title">

            <h2>Livestock Management Library</h2>
        </section>

        <div class="knowledge-grid">
            <div class="hub-card">
                <div class="card-img" style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?auto=format&fit=crop&q=80&w=400') center/cover;">Cattle & Ruminants</div>
                <div class="card-content">
                    <h3>Dairy & Beef Optimization</h3>
                    <p>Core methodologies regarding ruminant nutrition, pasture rotation matrixes, and milk yield improvement parameters.</p>
                    <ul>
                        <li>Balanced Total Mixed Ration (TMR) calculations</li>
                        <li>Silage preservation workflows</li>
                        <li>Automated heat detection frameworks</li>
                    </ul>
                    <a href="#" class="btn-read">Browse Core Modules</a>
                </div>
            </div>

            <div class="hub-card">
                <div class="card-img" style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?auto=format&fit=crop&q=80&w=400') center/cover;">Poultry Management</div>
                <div class="card-content">
                    <h3>Broiler & Layer Dynamics</h3>
                    <p>Environmental and clinical guidelines specializing in deep litter systems, biological security, and structural ventilation.</p>
                    <ul>
                        <li>FCR (Feed Conversion Ratio) fine-tuning</li>
                        <li>Lighting schedule schemas for layers</li>
                        <li>Brooding temperature matrix guidelines</li>
                    </ul>
                    <a href="#" class="btn-read">Browse Core Modules</a>
                </div>
            </div>

            <div class="hub-card">
                <div class="card-img" style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1604848698030-c434ba086c94?auto=format&fit=crop&q=80&w=400') center/cover;">Swine & Porcine</div>
                <div class="card-content">
                    <h3>Sustainable Swine Husbandry</h3>
                    <p>Advanced diagnostic information outlining sow farrowing care, herd biosecurity strategies, and artificial insemination.</p>
                    <ul>
                        <li>Sow nutrition pre- and post-farrowing</li>
                        <li>Waste management & biogas integration</li>
                        <li>Biosecurity barrier design patterns</li>
                    </ul>
                    <a href="#" class="btn-read">Browse Core Modules</a>
                </div>
            </div>
        </div>

        <section id="diseases" class="section-title">
            <h2>Quick Diagnostic & Prevention Matrix</h2>
        </section>

        <section class="diagnostic-matrix">
            <p style="color: var(--text-muted); margin-bottom: 20px;">Use this reference compilation matrix for emergency field identification. Always consult a certified veterinary expert before executing aggressive therapy workflows.</p>
            <table>
                <thead>
                    <tr>
                        <th>Disease Profile</th>
                        <th>Target Livestock</th>
                        <th>Primary Visual Indicators</th>
                        <th>Classification Status</th>
                        <th>Action Protocol</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Foot and Mouth Disease (FMD)</strong></td>
                        <td>Cattle, Swine, Sheep</td>
                        <td>High fever, blisters on hooves & mouth, excessive salivation</td>
                        <td><span class="badge">Critical Outbreak Risk</span></td>
                        <td>Quarantine immediately, ring vaccination, state notification.</td>
                    </tr>
                    <tr>
                        <td><strong>Newcastle Disease</strong></td>
                        <td>Poultry (Chickens, Turkeys)</td>
                        <td>Respiratory distress, twisted necks, drop in egg production</td>
                        <td><span class="badge">Highly Contagious</span></td>
                        <td>Complete flock isolation, vector culling, emergency vaccination.</td>
                    </tr>
                    <tr>
                        <td><strong>Mastitis</strong></td>
                        <td>Dairy Cattle / Goats</td>
                        <td>Swollen/painful udder quarters, clotted or watery milk production</td>
                        <td><span class="badge preventative">Production Threat</span></td>
                        <td>Strict pre-milking sanitation dipping, antibiotic dry-cow therapy.</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section id="share" class="section-title">
            <h2>Contribute to the Knowledge Ecosystem</h2>
        </section>

        <div class="share-section">
            <div class="share-info">
                <h3>Submit Your Field Findings</h3>
                <p>Are you a livestock scientist, extension professional, or veteran farmer? Share your localized breakthroughs, field observations, or research links to improve regional agriculture outcomes.</p>
                <p style="margin-top: 20px; color: var(--text-muted);">Submitted content goes through peer vetting before being indexed into our core open-access database modules.</p>
            </div>
            <div class="share-form">
                <form onsubmit="alert('Thank you for contributing! Your data has been submitted to peer review verification.'); return false;">
                    <div class="form-group">
                        <label for="name">Contributor Name / Entity</label>
                        <input type="text" id="name" placeholder="Dr. Jane Smith or GreenValley Farm" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Knowledge Area Tag</label>
                        <select id="category" required>
                            <option value="">Select Domain</option>
                            <option value="nutrition">Animal Nutrition & Feed Formulation</option>
                            <option value="pathology">Clinical Pathology & Disease Control</option>
                            <option value="infrastructure">Barn Design & Engineering</option>
                            <option value="breeding">Genetics & Insemination Strategy</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="content">Abstract / Knowledge Description</label>
                        <textarea id="content" rows="5" placeholder="Detail your operational procedure, case research summary, or field finding guidelines..." required></textarea>
                    </div>
                    <button type="submit">Submit for Vetting</button>
                </form>
            </div>
        </div>

    </div>

    <footer>
        <p>&copy; 2026 AgriKnow Open Agriculture Framework. Developed for Academic Project Integration.</p>
    </footer>

</body>
</html>

@endsection
