document.addEventListener("DOMContentLoaded", function () {
  const userAgent = navigator.userAgent;
  let browserName = "Unknown Browser";

  if (userAgent.includes("Chrome")) {
    browserName = "Chrome";
  } else if (userAgent.includes("Firefox")) {
    browserName = "Firefox";
  } else if (userAgent.includes("Safari") && !userAgent.includes("Chrome")) {
    browserName = "Safari";
  } else if (userAgent.includes("Edg")) {
    browserName = "Edge";
  }

  const language = navigator.language;
  const platform = navigator.platform;
  const isCookieEnabled = navigator.cookieEnabled;

  // Log the browser information to the console
  console.log("Browser Information:");
  console.log(`Browser Name: ${browserName}`);
  console.log(`User Agent: ${userAgent}`);
  console.log(`Language: ${language}`);
  console.log(`Platform: ${platform}`);
  console.log(`Cookies Enabled: ${isCookieEnabled ? 'Yes' : 'No'}`);
});
