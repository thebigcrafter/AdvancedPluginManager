# thebigcrafter maintenance

## Upstream compatibility watch

The `Check upstream compatibility` workflow in this repository checks the latest stable Axolotl-PM and DevTools releases against [`maintenance-baseline.json`](maintenance-baseline.json).

thebigcrafter currently has no organization `.github` repository, so this active repository hosts the organization-scoped watch without changing the organization identity or sharing ReinfyTeam state.

The scheduled run reports newer stable releases but does not change source, dependency pins, workflow references or releases. Use `workflow_dispatch` with `fail_on_update` enabled when a compatibility review should be required.

When an update is reported, review the release notes and run the affected thebigcrafter repository gates before updating any baseline or build pin. Keep the previous tested tag and commit in the organization progress record as the rollback reference.
