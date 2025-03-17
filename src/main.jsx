import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App";
import "./index.css";
const container = document.getElementById("wp-react-contact-form");
if (container) {
    ReactDOM.createRoot(container).render(<App />);
}
