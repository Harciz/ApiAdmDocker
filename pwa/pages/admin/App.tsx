import React from "react";
import { HydraAdmin } from "@api-platform/admin";

const entrypoint = "http://localhost/api";

export default function App() {
  return <HydraAdmin entrypoint={entrypoint} />;
}
